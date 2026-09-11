<?php

namespace App\Console\Commands;

use App\Http\Controllers\NotifyController;
use App\Mail\LaunchAnnouncement;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Throwable;

class AnnounceLaunch extends Command
{
    protected $signature = 'kithara:announce-launch
        {--dry-run : Show who would be emailed without sending anything}
        {--preview= : Send a single copy to this address and leave the list untouched}
        {--force : Skip the confirmation prompt}';

    protected $description = 'Email everyone on the notify-me list that Kithara is on Google Play, then clear the list';

    public function handle(): int
    {
        $url = config('kithara.play_store_url');

        if ($preview = $this->option('preview')) {
            Mail::to($preview)->send(new LaunchAnnouncement($url));
            $this->info("Preview sent to {$preview}.");

            return self::SUCCESS;
        }

        if (! config('kithara.play_live') || ! str_starts_with($url, 'https://')) {
            $this->error('Set KITHARA_PLAY_LIVE=true and a real KITHARA_PLAY_STORE_URL before announcing.');

            return self::FAILURE;
        }

        $disk = Storage::disk('local');
        $emails = $this->emails($disk->exists(NotifyController::LIST_FILE) ? $disk->get(NotifyController::LIST_FILE) : '');

        if ($emails === []) {
            $this->info('The notify-me list is empty. Nothing to send.');

            return self::SUCCESS;
        }

        $this->line(count($emails).' address(es) on the list.');

        if ($this->option('dry-run')) {
            foreach ($emails as $email) {
                $this->line("  {$email}");
            }
            $this->info('Dry run: nothing sent.');

            return self::SUCCESS;
        }

        if (! $this->option('force') && ! $this->confirm('Send the launch email to all of them and clear the list?')) {
            $this->info('Cancelled.');

            return self::SUCCESS;
        }

        $failed = [];
        $bar = $this->output->createProgressBar(count($emails));

        foreach ($emails as $email) {
            try {
                Mail::to($email)->send(new LaunchAnnouncement($url));
            } catch (Throwable $e) {
                $failed[$email] = $e->getMessage();
            }
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();

        // Keep only the addresses that failed so a re-run retries just those.
        // A clean run removes the file entirely, as the privacy policy promises.
        if ($failed === []) {
            $disk->delete(NotifyController::LIST_FILE);
            $this->info('Sent to '.count($emails).' address(es). The list has been deleted.');

            return self::SUCCESS;
        }

        $disk->put(NotifyController::LIST_FILE, implode("\n", array_map(
            fn (string $email) => now()->toIso8601String().','.$email,
            array_keys($failed),
        )));

        $this->warn('Sent to '.(count($emails) - count($failed)).', failed '.count($failed).'. Failed addresses kept in the list; run again to retry.');
        foreach ($failed as $email => $reason) {
            $this->line("  {$email}: {$reason}");
        }

        return self::FAILURE;
    }

    /**
     * Parse the "timestamp,email" lines into a unique list of addresses.
     *
     * @return list<string>
     */
    private function emails(string $csv): array
    {
        $emails = [];

        foreach (explode("\n", $csv) as $line) {
            $parts = explode(',', trim($line));
            $email = mb_strtolower(trim(end($parts)));
            if ($email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emails[$email] = true;
            }
        }

        return array_keys($emails);
    }
}

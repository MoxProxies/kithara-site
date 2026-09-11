<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class GuidePagesTest extends TestCase
{
    /** @return array<string, array{string, string}> */
    public static function pages(): array
    {
        return [
            'pro' => ['/pro', 'Free versus Pro'],
            'audiobookshelf' => ['/audiobookshelf', 'Setting it up'],
            'transcripts' => ['/transcripts', 'Choosing a model'],
            'formats' => ['/formats', 'Where chapters come from'],
            'android-auto' => ['/android-auto', 'Voice search'],
            'sync-protocol' => ['/sync-protocol', 'How a client resolves conflicts'],
            'howto.m4b-chapters' => ['/how-to/add-chapters-to-m4b', '-map_chapters 1'],
            'changelog' => ['/changelog', '1.0.0'],
            'compare' => ['/compare', 'How these are written'],
            'compare.smart-audiobook-player' => ['/compare/smart-audiobook-player', 'Where Smart AudioBook Player is the better choice'],
            'compare.audiobookshelf-app' => ['/compare/audiobookshelf-app', 'Or use both'],
            'compare.audible' => ['/compare/audible', 'Where Audible is the right choice'],
        ];
    }

    #[DataProvider('pages')]
    public function test_guide_page_renders_with_breadcrumbs_and_unique_description(string $path, string $heading): void
    {
        $response = $this->get($path)->assertOk()->assertSee($heading);
        $html = $response->getContent();

        $this->assertStringContainsString('"BreadcrumbList"', $html);
        $this->assertMatchesRegularExpression('/<meta name="description" content="[^"]{60,}"/', $html);
        $this->assertStringNotContainsString('—', $html, 'no em-dashes on the site');
    }

    public function test_guide_pages_are_in_the_sitemap_and_llms_txt(): void
    {
        foreach (array_keys(self::pages()) as $name) {
            $this->get('/sitemap.xml')->assertSee(route($name));
            $this->get('/llms.txt')->assertSee(route($name));
        }
    }

    public function test_sync_protocol_renders_the_markdown_spec(): void
    {
        $this->get('/sync-protocol')
            ->assertOk()
            ->assertSee('<pre><code class="language-json">', false)
            ->assertSee('PUT /api/progress/{bookId}')
            ->assertDontSee('an Kithara')
            ->assertSee('"TechArticle"', false);
    }

    public function test_pro_page_follows_the_play_live_flag(): void
    {
        config(['kithara.play_live' => false]);
        $this->get('/pro')->assertSee('in review with Google Play')->assertDontSee('Get it on Google Play');

        config(['kithara.play_live' => true, 'kithara.play_store_url' => 'https://play.google.com/store/apps/details?id=com.kithara']);
        $this->get('/pro')->assertSee('Get it on Google Play')->assertDontSee('in review with Google Play');
    }

    public function test_changelog_feed_lists_every_release(): void
    {
        $xml = $this->get('/changelog.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/rss+xml; charset=utf-8')
            ->getContent();

        $items = simplexml_load_string($xml)->channel->item;
        $this->assertCount(\App\Support\Releases::all()->count(), $items);
        $this->assertStringContainsString('1.0.0', (string) $items[0]->title);
    }

    public function test_app_schema_only_reports_a_version_once_one_has_shipped(): void
    {
        $html = $this->get('/')->getContent();
        $shipped = \App\Support\Releases::latestReleased();

        if ($shipped) {
            $this->assertStringContainsString('"softwareVersion":"'.$shipped['version'].'"', $html);
        } else {
            $this->assertStringNotContainsString('softwareVersion', $html);
        }
    }

    public function test_how_to_page_carries_howto_schema(): void
    {
        $html = $this->get('/how-to/add-chapters-to-m4b')->assertOk()->getContent();

        preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $html, $blocks);
        $types = array_map(fn ($json) => json_decode($json, true, 512, JSON_THROW_ON_ERROR)['@type'] ?? null, $blocks[1]);

        $this->assertContains('HowTo', $types);
        $this->assertContains('BreadcrumbList', $types);
    }
}

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
            'sync-protocol' => ['/sync-protocol', 'How conflicts are resolved'],
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
}

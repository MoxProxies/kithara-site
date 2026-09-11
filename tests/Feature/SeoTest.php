<?php

namespace Tests\Feature;

use Tests\TestCase;

class SeoTest extends TestCase
{
    public function test_home_page_carries_valid_structured_data(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $html, $blocks);
        $this->assertCount(2, $blocks[1], 'expected a site graph and a FAQPage block');

        $graph = json_decode($blocks[1][0], true, 512, JSON_THROW_ON_ERROR);
        $types = array_map(fn ($node) => (array) $node['@type'], $graph['@graph']);
        $this->assertContains(['Organization'], $types);
        $this->assertContains(['WebSite'], $types);
        $this->assertContains(['SoftwareApplication', 'MobileApplication'], $types);

        $faq = json_decode($blocks[1][1], true, 512, JSON_THROW_ON_ERROR);
        $this->assertSame('FAQPage', $faq['@type']);
        $this->assertGreaterThanOrEqual(8, count($faq['mainEntity']));

        // Every FAQ answer in the schema is also visible on the page
        foreach ($faq['mainEntity'] as $question) {
            $this->assertStringContainsString(e($question['name']), $html);
        }
    }

    public function test_head_has_social_cards_and_no_third_party_fonts(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('<title>Kithara: Audiobook Player for Android with Audiobookshelf Sync</title>', false)
            ->assertSee('property="og:image"', false)
            ->assertSee('name="twitter:card" content="summary_large_image"', false)
            ->assertSee('rel="apple-touch-icon"', false)
            ->assertDontSee('fonts.googleapis.com');
    }

    public function test_titles_and_descriptions_are_unique_and_not_double_escaped(): void
    {
        $this->get('/terms')->assertSee('<title>Terms &amp; Conditions · Kithara</title>', false)->assertDontSee('&amp;amp;', false);
        $this->get('/privacy')->assertSee('<title>Privacy Policy · Kithara</title>', false);

        $descriptions = collect(['/', '/contact', '/terms', '/privacy'])
            ->map(fn ($path) => preg_match('/name="description" content="([^"]+)"/', $this->get($path)->getContent(), $m) ? $m[1] : null);

        $this->assertCount(4, $descriptions->filter()->unique());
    }

    public function test_crawler_files_are_served(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml')
            ->assertSee(route('home'))
            ->assertSee(route('privacy'));

        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Sitemap: '.route('sitemap'))
            ->assertSee('Disallow: /notify');

        $this->get('/llms.txt')
            ->assertOk()
            ->assertSee('# Kithara')
            ->assertSee('Android 8.0');
    }

    public function test_404_is_branded(): void
    {
        $this->get('/no-such-page')
            ->assertNotFound()
            ->assertSee('Page not found · Kithara')
            ->assertSee('Back to Kithara');
    }

    public function test_every_json_ld_block_on_every_page_is_valid_schema_org(): void
    {
        $paths = ['/', '/contact', '/terms', '/privacy', '/pro', '/audiobookshelf', '/transcripts', '/formats',
            '/android-auto', '/sync-protocol', '/changelog', '/compare', '/compare/audible',
            '/how-to/add-chapters-to-m4b', '/how-to/audiobookshelf-setup', '/how-to/leaving-audible'];

        foreach ($paths as $path) {
            $html = $this->get($path)->assertOk()->getContent();
            preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $html, $blocks);
            $this->assertNotEmpty($blocks[1], "$path has no structured data");

            foreach ($blocks[1] as $json) {
                $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
                $this->assertSame('https://schema.org', $data['@context'] ?? null, "$path: a JSON-LD block is missing @context (Blade directive leak?)");
                $this->assertStringNotContainsString('<?php', $json, "$path: compiled PHP leaked into JSON-LD");
            }
        }
    }
}

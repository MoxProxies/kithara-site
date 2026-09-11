<?php

namespace Tests\Feature;

use Tests\TestCase;

class PlayStoreFlagTest extends TestCase
{
    public function test_store_buttons_are_coming_soon_pills_until_the_listing_is_live(): void
    {
        config(['kithara.play_live' => false, 'kithara.play_store_url' => 'https://play.google.com/store/apps/details?id=com.kithara']);

        $this->get('/')
            ->assertOk()
            ->assertSee('Coming soon to Google Play')
            ->assertDontSee('Get it on Google Play')
            ->assertDontSee('play.google.com');

        $this->get('/contact')
            ->assertOk()
            ->assertSee('not on Google Play yet');
    }

    public function test_store_buttons_link_to_google_play_once_live(): void
    {
        config(['kithara.play_live' => true, 'kithara.play_store_url' => 'https://play.google.com/store/apps/details?id=com.kithara']);

        $this->get('/')
            ->assertOk()
            ->assertSee('Get it on Google Play')
            ->assertSee('play.google.com/store/apps/details?id=com.kithara')
            ->assertDontSee('Coming soon to Google Play');

        $this->get('/contact')
            ->assertOk()
            ->assertSee('Purchases are handled by Google Play');
    }
}

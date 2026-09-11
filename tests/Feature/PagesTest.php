<?php

namespace Tests\Feature;

use Tests\TestCase;

class PagesTest extends TestCase
{
    public function test_home_page_renders(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Appollo')
            ->assertSee('Features');
    }

    public function test_terms_page_renders(): void
    {
        $this->get('/terms')
            ->assertOk()
            ->assertSee('Terms &amp; Conditions', false)
            ->assertSee(config('appollo.company_name'));
    }

    public function test_privacy_page_renders(): void
    {
        $this->get('/privacy')
            ->assertOk()
            ->assertSee('Privacy Policy')
            ->assertSee(config('appollo.support_email'));
    }
}

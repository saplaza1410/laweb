<?php

namespace Tests\Feature;

use Tests\TestCase;

class PagesTest extends TestCase
{
    public function test_home_returns_200(): void
    {
        $this->get('/')->assertStatus(200);
    }

    public function test_home_alias_returns_200(): void
    {
        $this->get('/home')->assertStatus(200);
    }

    public function test_services_returns_200(): void
    {
        $this->get('/services')->assertStatus(200);
    }

    public function test_we_returns_200(): void
    {
        $this->get('/we')->assertStatus(200);
    }

    public function test_contacts_returns_200(): void
    {
        $this->get('/contacts')->assertStatus(200);
    }

    public function test_we_page_links_to_contacts(): void
    {
        $this->get('/we')->assertSee('<a href="/contacts" class="text-primary">', false);
    }

    public function test_logo_uses_asset_helper(): void
    {
        $this->get('/')->assertSee('img/logo.png');
    }
}

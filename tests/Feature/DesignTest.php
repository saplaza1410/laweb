<?php

namespace Tests\Feature;

use Tests\TestCase;

class DesignTest extends TestCase
{
    public function test_app_loads_inter_font(): void
    {
        $this->get('/')->assertSee('fonts.googleapis.com', false);
    }

    public function test_navbar_has_brand_dot(): void
    {
        $this->get('/')->assertSee('brand-dot', false);
    }

    public function test_navbar_has_scroll_script(): void
    {
        $this->get('/')->assertSee('scrolled', false);
    }

    public function test_navbar_has_social_bar_class(): void
    {
        $this->get('/')->assertSee('social-bar', false);
    }

    public function test_home_has_hero_caption(): void
    {
        $this->get('/')->assertSee('hero-caption', false);
    }

    public function test_home_has_stats_bar(): void
    {
        $this->get('/')->assertSee('stats-bar', false);
    }

    public function test_home_has_cta_section(): void
    {
        $this->get('/')->assertSee('cta-section', false);
    }
}

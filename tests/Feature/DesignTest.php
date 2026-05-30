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

    public function test_services_page_has_service_icons(): void
    {
        $this->get('/services')->assertSee('service-icon', false);
    }

    public function test_services_page_has_fa_code_icon(): void
    {
        $this->get('/services')->assertSee('fa-code', false);
    }

    public function test_services_page_has_page_header(): void
    {
        $this->get('/services')->assertSee('page-header', false);
    }

    public function test_we_page_has_timeline(): void
    {
        $this->get('/we')->assertSee('timeline', false);
    }

    public function test_we_page_has_timeline_dot(): void
    {
        $this->get('/we')->assertSee('timeline-dot', false);
    }

    public function test_we_page_has_section_icons(): void
    {
        $this->get('/we')->assertSee('section-icon', false);
    }

    public function test_contacts_page_has_info_card(): void
    {
        $this->get('/contacts')->assertSee('contact-info-card', false);
    }

    public function test_contacts_page_has_form_card(): void
    {
        $this->get('/contacts')->assertSee('contact-form-card', false);
    }

    public function test_contacts_page_has_paper_plane_icon(): void
    {
        $this->get('/contacts')->assertSee('fa-paper-plane', false);
    }
}

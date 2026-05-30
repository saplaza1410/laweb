<?php

namespace Tests\Feature;

use Tests\TestCase;

class LocaleTest extends TestCase
{
    public function test_default_locale_is_spanish(): void
    {
        $this->get('/');
        $this->assertEquals('es', app()->getLocale());
    }

    public function test_locale_can_be_switched_to_english(): void
    {
        $this->get('/lang/en')->assertRedirect();
        $this->assertEquals('en', session('locale'));
    }

    public function test_locale_can_be_switched_to_french(): void
    {
        $this->get('/lang/fr')->assertRedirect();
        $this->assertEquals('fr', session('locale'));
    }

    public function test_invalid_locale_returns_404(): void
    {
        $this->get('/lang/de')->assertStatus(404);
    }

    public function test_locale_persists_across_requests(): void
    {
        $this->get('/lang/en');
        $this->get('/');
        $this->assertEquals('en', app()->getLocale());
    }

    public function test_home_shows_spanish_by_default(): void
    {
        $this->get('/')->assertSee('Bienvenido a Mi Sitio Web');
    }

    public function test_home_shows_english_after_switch(): void
    {
        $this->get('/lang/en');
        $this->get('/')->assertSee('Welcome to My Website');
    }

    public function test_home_shows_french_after_switch(): void
    {
        $this->get('/lang/fr');
        $this->get('/')->assertSee('Bienvenue sur Mon Site Web');
    }

    public function test_nav_shows_translated_links(): void
    {
        $this->get('/lang/en');
        $this->get('/')->assertSee('Home')->assertSee('Services');
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;

class DesignTest extends TestCase
{
    public function test_app_loads_inter_font(): void
    {
        $this->get('/')->assertSee('fonts.googleapis.com', false);
    }
}

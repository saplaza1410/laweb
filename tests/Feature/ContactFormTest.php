<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_stores_message_in_database(): void
    {
        $this->post('/contacts', [
            'name'    => 'Ana García',
            'email'   => 'ana@example.com',
            'message' => 'Hola, me interesa tu trabajo.',
        ])->assertRedirect('/contacts');

        $this->assertDatabaseHas('contacts', [
            'name'  => 'Ana García',
            'email' => 'ana@example.com',
        ]);
    }

    public function test_contact_form_redirects_with_success_flash(): void
    {
        $this->post('/contacts', [
            'name'    => 'Pedro López',
            'email'   => 'pedro@example.com',
            'message' => 'Consulta sobre servicios.',
        ])->assertRedirect('/contacts')
          ->assertSessionHas('success');
    }

    public function test_contact_form_requires_name(): void
    {
        $this->post('/contacts', [
            'email'   => 'test@example.com',
            'message' => 'Mensaje.',
        ])->assertSessionHasErrors('name');
    }

    public function test_contact_form_requires_valid_email(): void
    {
        $this->post('/contacts', [
            'name'    => 'Test',
            'email'   => 'no-es-un-email',
            'message' => 'Mensaje.',
        ])->assertSessionHasErrors('email');
    }

    public function test_contact_form_requires_message(): void
    {
        $this->post('/contacts', [
            'name'  => 'Test',
            'email' => 'test@example.com',
        ])->assertSessionHasErrors('message');
    }

    public function test_contact_form_rejects_message_over_5000_chars(): void
    {
        $this->post('/contacts', [
            'name'    => 'Test',
            'email'   => 'test@example.com',
            'message' => str_repeat('a', 5001),
        ])->assertSessionHasErrors('message');
    }
}

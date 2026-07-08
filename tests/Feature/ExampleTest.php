<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_landing_pages_render_without_errors(): void
    {
        $routes = [
            '/',
            '/sobre',
            '/contato',
            '/programas',
            '/jogos',
            '/equipe',
            '/blog',
            '/faq',
        ];

        foreach ($routes as $uri) {
            $this->get($uri)->assertOk();
        }
    }
}

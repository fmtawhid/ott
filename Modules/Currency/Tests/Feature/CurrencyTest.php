<?php

namespace Modules\Currency\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CurrencyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test Currency.
     *
     * @return void
     */
    public function test_backend_currencies_list_page()
    {
        $this->signInAsAdmin();

        $response = $this->get('app/currencies');

        $response->assertStatus(200);
    }
}

<?php

namespace Modules\Tax\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaxTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test Tax.
     *
     * @return void
     */
    public function test_backend_taxes_list_page()
    {
        $this->signInAsAdmin();

        $response = $this->get('app/taxes');

        $response->assertStatus(200);
    }
}

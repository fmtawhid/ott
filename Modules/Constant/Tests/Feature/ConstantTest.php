<?php

namespace Modules\Constant\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConstantTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test Constant.
     *
     * @return void
     */
    public function test_backend_constants_list_page()
    {
        $this->signInAsAdmin();

        $response = $this->get('app/constants');

        $response->assertStatus(200);
    }
}

<?php

namespace Modules\User\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test User.
     *
     * @return void
     */
    public function test_backend_users_list_page()
    {
        $this->signInAsAdmin();

        $response = $this->get('app/users');

        $response->assertStatus(200);
    }
}

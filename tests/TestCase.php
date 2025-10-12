<?php

namespace Tests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signInAsAdmin($user = null)
    {
        $user = $user ?: User::factory()->create();

        $admin = Role::create(['name' => 'admin', 'title' => 'Admin']);

        $user->assignRole('admin');

        $this->actingAs($user);

        return $user;
    }
}

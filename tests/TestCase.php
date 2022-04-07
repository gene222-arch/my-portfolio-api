<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\Feature\Http\Controllers\Api\Auth\LoginControllerTest;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('db:seed');

        if (! $this === LoginControllerTest::class) {
            Passport::actingAs(User::factory()->create(), [], 'api');
        } else {
            Artisan::call('passport:install');
        }

        $this->withoutExceptionHandling();
    }
}

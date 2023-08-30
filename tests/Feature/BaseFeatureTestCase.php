<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Sanctum\Sanctum;
use Tests\RefreshDatabase;
use Tests\TestCase;

class BaseFeatureTestCase extends TestCase
{
    use RefreshDatabase;
    use DatabaseTruncation;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    protected function actingAsUser(User $user): self
    {
        Sanctum::actingAs($user);

        return $this;
    }
}

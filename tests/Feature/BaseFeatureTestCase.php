<?php

namespace Tests\Feature;

use App\Enum\UserEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Sanctum\Sanctum;
use Tests\RefreshDatabase;
use Tests\TestCase;

class BaseFeatureTestCase extends TestCase
{
    use DatabaseTruncation;
    use RefreshDatabase;

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

    protected function actingAsSuperUser(): self
    {
        $superUser = User::query()->where('id', UserEnum::SUPER_USER->value)->first();

        Sanctum::actingAs($superUser);

        return $this;
    }
}

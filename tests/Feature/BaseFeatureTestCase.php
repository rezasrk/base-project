<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTruncation;
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
}

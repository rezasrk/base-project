<?php

namespace Tests\Unit;

use Tests\TestCase;

class BaseUnitTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }
}

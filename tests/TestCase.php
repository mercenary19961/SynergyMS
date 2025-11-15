<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $defaultMiddleware = [];

    protected function setUp(): void
    {
        parent::setUp();

        // Start a session for testing
        $this->withSession([]);
    }
}

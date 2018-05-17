<?php

namespace Tests;

use App\Lottery;
use App\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        \Artisan::call('db:seed');
        Lottery::config();
        // Setting::config();
    }
}

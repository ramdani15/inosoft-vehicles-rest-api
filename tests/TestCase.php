<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use WithFaker;

    protected $defaultPassword = 'test1234';

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpFaker();
        Artisan::call('migrate:fresh --seed');
    }
}

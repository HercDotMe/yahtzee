<?php

namespace unit\App\Security\Controller;

use PHPUnit\Framework\TestCase;
use App\Security\Controller\TestController;

class TestControllerTest extends TestCase
{
    public function testConstructorWorks()
    {
        $controller = new TestController();

        $this->assertInstanceOf(TestController::class, $controller);
    }
}
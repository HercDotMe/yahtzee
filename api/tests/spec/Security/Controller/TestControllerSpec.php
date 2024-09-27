<?php

namespace spec\App\Security\Controller;

use App\Security\Controller\TestController;
use PhpSpec\ObjectBehavior;

class TestControllerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TestController::class);
    }
}

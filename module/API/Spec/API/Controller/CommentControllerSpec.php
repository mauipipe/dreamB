<?php

namespace Spec\API\Controller;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommentControllerSpec extends ObjectBehavior
{
    function it_implements_restful_controller()
    {
        $this->beAnInstanceOf('Zend\Mvc\Controller\AbstractRestfulController');
    }
}

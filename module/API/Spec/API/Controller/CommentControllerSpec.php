<?php

namespace Spec\API\Controller;

use API\Service\CommentService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommentControllerSpec extends ObjectBehavior
{
    function it_implements_restful_controller()
    {
        $this->beAnInstanceOf('Zend\Mvc\Controller\AbstractRestfulController');
    }

    function let(CommentService $commentService)
    {
        $this->beConstructedWith($commentService);
    }
}

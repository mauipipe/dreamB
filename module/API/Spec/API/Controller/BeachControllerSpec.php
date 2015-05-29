<?php

namespace Spec\API\Controller;

use API\Service\BeachService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BeachControllerSpec extends ObjectBehavior
{

   /* function let(BeachService $beachService){
        $this->beConstructedWith($beachService);
    }*/

    function it_implements_restful_controller()
    {
        $this->beAnInstanceOf('Zend\Mvc\Controller\AbstractRestfulController');
    }
}

<?php

namespace Spec\API\Controller;

use API\Service\CityService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CityControllerSpec extends ObjectBehavior
{
    function it_implements_restful_controller()
    {
        $this->beAnInstanceOf('Zend\Mvc\Controller\AbstractRestfulController');
    }

    function let(CityService $cityService)
    {
        $this->beConstructedWith($cityService);
    }
}

<?php

namespace Spec\API\Controller;

use API\Service\CityService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceManager;

class CityControllerFactorySpec extends ObjectBehavior
{
    function it_implements_factory_interface()
    {
        $this->beAnInstanceOf('Zend\ServiceManager\FactoryInterface');
    }

    function it_create_a_beach_service(
        ControllerManager $controllerManager,
        ServiceManager $serviceManager,
        CityService $cityService
    )
    {
        $controllerManager->getServiceLocator()->shouldBeCalled()->willReturn($serviceManager);
        $serviceManager->get('city.service')->shouldBeCalled()->willReturn($cityService);
        $this->createService($controllerManager)->shouldBeAnInstanceOf('API\Controller\CityController');
    }
}

<?php

namespace Spec\API\Controller;

use API\Controller\BeachController;
use API\Service\BeachService;
use Doctrine\ORM\EntityManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceManager;

class BeachControllerFactorySpec extends ObjectBehavior
{
    function it_implements_factory_interface()
    {
        $this->beAnInstanceOf('Zend\ServiceManager\FactoryInterface');
    }

    function it_create_a_beach_service(
        ControllerManager $controllerManager,
        ServiceManager $serviceManager,
        BeachService $beachService
    )
    {
        $controllerManager->getServiceLocator()->shouldBeCalled()->willReturn($serviceManager);
        $serviceManager->get('beach.service')->shouldBeCalled()->willReturn($beachService);
        $this->createService($controllerManager)->shouldBeAnInstanceOf('API\Controller\BeachController');
    }

}

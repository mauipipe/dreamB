<?php

namespace Spec\API\Controller;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceManager;

class CommentControllerFactorySpec extends ObjectBehavior
{
    function it_implements_factory_interface()
    {
        $this->beAnInstanceOf('Zend\ServiceManager\FactoryInterface');
    }

    function it_create_a_beach_service(
        ControllerManager $controllerManager,
        ServiceManager $serviceManager
    )
    {
        $controllerManager->getServiceLocator()->shouldBeCalled()->willReturn($serviceManager);
        $this->createService($controllerManager)->shouldBeAnInstanceOf('API\Controller\CommentController');
    }
}

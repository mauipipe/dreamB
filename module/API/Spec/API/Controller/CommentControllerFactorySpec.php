<?php

namespace Spec\API\Controller;

use API\Service\CommentService;
use Application\Service\ImageService;
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
        ServiceManager $serviceManager,
        CommentService $commentService,
        ImageService $imageService
    )
    {
        $controllerManager->getServiceLocator()->shouldBeCalled()->willReturn($serviceManager);
        $serviceManager->get('comment.service')->shouldBeCalled()->willReturn($commentService);
        $serviceManager->get('application_image.service')->shouldBeCalled()->willReturn($imageService);
        $this->createService($controllerManager)->shouldBeAnInstanceOf('API\Controller\CommentController');
    }
}

<?php

namespace Spec\Application\Service;

use Application\Service\ImageService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Zend\ServiceManager\ServiceManager;

class ImageServiceFactorySpec extends ObjectBehavior
{
    function it_implements_factory_interface()
    {
        $this->beAnInstanceOf('Zend\ServiceManager\FactoryInterface');
    }

    function it_create_a_image_service(
        ServiceManager $serviceManager
    )
    {
        $config = array(
            'base_image_path' => 'example_path'
        );
        $serviceManager->get('Config')->shouldBeCalled()->willReturn($config);
        $this->createService($serviceManager)->shouldBeAnInstanceOf('Application\Service\ImageService');
    }

}

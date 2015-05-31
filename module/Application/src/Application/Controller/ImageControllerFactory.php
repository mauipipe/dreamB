<?php

namespace Application\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ImageControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();
        $imagine = $sm->get('HtImg\Imagine');
        $config = $sm->get('Config');
        $imagePath = $config['base_image_path'];
        

        return new ImageController($imagePath,$imagine);

    }
}

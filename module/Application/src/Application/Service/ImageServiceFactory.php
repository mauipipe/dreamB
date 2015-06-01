<?php

namespace Application\Service;

use Zend\File\Transfer\Adapter\Http;
use Zend\ServiceManager\ServiceLocatorInterface;

class ImageServiceFactory implements \Zend\ServiceManager\FactoryInterface
{


    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $imgDefaultFolder = $config['base_image_path'];

        $httpAdapter = new Http();

        return new ImageService($httpAdapter, $config);
    }
}

<?php
/**
 * Created by David Contavalli <david.contavalli@gmail.com>
 */

namespace API\Controller\Plugin;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RestParamsValidatorFactory implements FactoryInterface{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->getServiceLocator()->get('Config');
        $apiAllowedParamsConfig = $config['api_params_validation'];

        return new RestParamsValidator($apiAllowedParamsConfig);
    }
}
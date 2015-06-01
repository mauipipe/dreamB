<?php

namespace API\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CommentServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $hm = $serviceLocator->get('HydratorManager');
        $commentHydrator = $hm->get('comment_hydrator');

        $em = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $beachRepository = $em->getRepository('API\Entity\Comment');
        return new CommentService($beachRepository,$commentHydrator,$em);

    }
}

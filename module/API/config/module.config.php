<?php
namespace API;
return array(
    'router'                => array(
        'routes' => array(
            'api' => array(
                'type'          => 'Zend\Mvc\Router\Http\Hostname',
                'options'       => array(
                    'route' => 'api.dream-beach.local'
                ),
                'priority'      => '100',
                'may_terminate' => true,
                'child_routes'  => array(
                    'root'    => array(
                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route'    => '/',
                            'defaults' => array(
                                'controller' => 'API\Controller\Index',
                                'action'=>'index'
                            ),
                        ),
                    ),
                    'beach'   => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'       => '/beach[/:id]',
                            'constraints' => array(
                                'id' => '[0-9]+',
                            ),
                            'defaults'    => array(
                                'controller' => 'API\Controller\Beach',
                            ),
                        ),
                    ),
                    'comment' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'       => '/comment[/:id]',
                            'constraints' => array(
                                'id' => '[0-9]+',
                            ),
                            'defaults'    => array(
                                'controller' => 'API\Controller\Comment',
                            ),
                        ),
                    ),
                    'city'    => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'       => '/city[/:id]',
                            'constraints' => array(
                                'id' => '[0-9]+',
                            ),
                            'defaults'    => array(
                                'controller' => 'API\Controller\City',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'view_manager'          => array(
        'strategies' => array(
            'ViewJsonStrategy'
        ),
        'template_path_stack'      => array(
            __DIR__ . '/../view',
        )
    ),

    'doctrine-hydrator'     => array(
        'beach_hydrator'   => array(
            'entity_class'   => 'API\Entity\Beach',
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value'       => true,
            'strategies'     => array(
                'city' => 'beach.strategy',
            ),
        ),
        'city_hydrator'    => array(
            'entity_class'   => 'API\Entity\Beach',
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value'       => true,
        ),
        'comment_hydrator' => array(
            'entity_class'   => 'API\Entity\Beach',
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value'       => true,
            'strategies'     => array(
                'beach' => 'comment.strategy',
                'creationDate' => 'dateTime.strategy'
            ),
        )
    ),
    'doctrine'              => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default'             => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        ),
    ),
    'api_params_validation' => array(
        'API\Controller\CommentController' => array(
            'POST' => array(
                'allowed_params' => array(
                    'name', 'description', 'lastName', 'beach_id','title'
                ),
                'forbidden_values'=>array(
                    'undefined'
                ),
                'filter_class'   => 'API\Validator\CommentInputFilter'
            ),
            'GET'  => array(
                'allowed_params' => array(
                    'city_id'
                )
            )

        ),

        'API\Controller\BeachController'   => array(
            'POST' => array(
                'allowed_params' => array(
                    'name', 'city_id'
                ),
                'forbidden_values'=>array(
                  'undefined'
                ),
                'filter_class'   => 'API\Validator\BeachInputFilter'
            ),
            'GET'  => array()
        )

    )

);
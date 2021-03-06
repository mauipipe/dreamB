<?php
namespace API;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;

class Module
{

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onDispatchError'), 0);
        $eventManager->attach(MvcEvent::EVENT_RENDER_ERROR, array($this, 'onRenderError'), 0);
    }

    public function onDispatchError($e)
    {
        return $this->getJsonModelError($e);
    }

    public function onRenderError($e)
    {
        return $this->getJsonModelError($e);
    }

    public function getJsonModelError($e)
    {
        $routeMatch = $e->getRouteMatch();
        if (is_null($routeMatch)) {
            return;
        }
        $controllerName = $routeMatch->getParam('controller');

        if (is_null($controllerName) ||  (false === strpos('API', $controllerName))) {
            return;
        }

        $error = $e->getError();
        if (!$error) {
            return;
        }
        $response = $e->getResponse();
        $exception = $e->getParam('exception');
        $exceptionJson = array();
        if ($exception) {
            $exceptionJson = array(
                'class'      => get_class($exception),
                'file'       => $exception->getFile(),
                'line'       => $exception->getLine(),
                'message'    => $exception->getMessage(),
                'stacktrace' => $exception->getTraceAsString()
            );
        }
        $errorJson = array(
            'message'   => 'An error occurred during execution; please try again later.',
            'error'     => $error,
            'exception' => $exceptionJson,
        );
        if ($error == 'error-router-no-match') {
            $errorJson['message'] = 'Resource not found.';
        }
        $model = new JsonModel(array('errors' => array($errorJson)));
        $e->setResult($model);
        return $model;
    }


    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getControllerConfig()
    {
        return array(
            'invokables' => array(
                'API\Controller\Index' => 'API\Controller\IndexController'
            ),
            'factories'  => array(
                'API\Controller\Beach'   => 'API\Controller\BeachControllerFactory',
                'API\Controller\Comment' => 'API\Controller\CommentControllerFactory',
                'API\Controller\City'    => 'API\Controller\CityControllerFactory'
            )
        );
    }

    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'comment.strategy' => 'API\Service\Strategy\CommentStrategy',
                'beach.strategy'   => 'API\Service\Strategy\BeachStrategy',
                'datetime.strategy'   => 'API\Service\Strategy\DateTimeStrategy'
            ),
            'factories'  => array(
                'beach.service'   => 'API\Service\BeachServiceFactory',
                'comment.service' => 'API\Service\CommentServiceFactory',
                'city.service'    => 'API\Service\CityServiceFactory'
            )
        );
    }

    public function getControllerPluginConfig()
    {
        return array(
            'invokables' => array(
                'imageLinkCreator' => 'API\Controller\Plugin\ImageLinkCreator'
            ),
            'factories' => array(
                'restParamsValidator'=>'API\Controller\Plugin\RestParamsValidatorFactory'
            )
        );
    }


}

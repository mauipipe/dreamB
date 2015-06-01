<?php
/**
 * Created by David Contavalli <david.contavalli@gmail.com>
 */

namespace API\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class RestParamsValidator extends AbstractPlugin
{

    private $apiValidationParamsConfig;
    private $errors = array();

    public function __construct(array $apiValidationParamsConfig)
    {
        $this->apiValidationParamsConfig = $apiValidationParamsConfig;
    }

    public function isValid($data, $allowEmpty = false)
    {
        $controller = $this->getController();
        $request = $controller->getRequest();
        $method = $request->getMethod();

        if ($allowEmpty && sizeof($data) === 0) {
            var_dump($data);
            return true;
        }

        $controllerClass = get_class($controller);
        if (array_key_exists($controllerClass, $this->apiValidationParamsConfig)) {
            $apiValidationParams = $this->apiValidationParamsConfig[$controllerClass][$method];

            $paramDiff = $this->getDiff($data, $apiValidationParams);
            if (sizeof($paramDiff) > 0) {
                $this->errors['malformed_params'] =  $paramDiff;
                return false;
            };

            if (isset($apiValidationParams['filter_class'])) {
                $filter = new $apiValidationParams['filter_class']();
                $filter->setData($data);
                $hasValidData = $filter->isValid();

                $this->errors['invalid_data'] = $filter->getMessages();
                return $hasValidData;
            }
        }
        return true;
    }

    /**
     * @param $data
     * @param $apiValidationParams
     * @return array
     */
    private function getDiff($data, $apiValidationParams)
    {
        $paramsKey = array_keys($data);
        $paramDiff = array_diff($apiValidationParams['allowed_params'], $paramsKey);
        $paramInverseDiff = array_diff($paramsKey, $apiValidationParams['allowed_params']);

        $result = array(
            'mismatch_allowed_params' => implode(',',$paramDiff),
            'unknown_params'          => implode(',',$paramInverseDiff)
        );

        return $result;
    }

    public function getErrors()
    {
        return $this->errors;
    }

}
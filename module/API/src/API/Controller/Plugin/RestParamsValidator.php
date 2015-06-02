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

    /**
     * @param $data
     * @param bool $allowEmpty
     * @return bool
     */
    public function isValid($data, $allowEmpty = false)
    {

        if ($allowEmpty && sizeof($data) === 0) {
            return true;
        }

        $controller = $this->getController();
        $request = $controller->getRequest();
        $method = $request->getMethod();

        $controllerClass = get_class($controller);
        if (array_key_exists($controllerClass, $this->apiValidationParamsConfig)) {
            $apiValidationParams = $this->apiValidationParamsConfig[$controllerClass][$method];

            if (($method === 'POST' || $method === 'PUT' || $method === 'PATCH') &&
                $this->hasMalformedValues($data, $apiValidationParams)
            ) {
                return false;
            }

            if ($this->hasMalformedParams($data, $apiValidationParams)) {
                return false;
            }

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
     * @param $apiValidationPar
     * @return bool
     */
    private function hasMalformedParams($data, $apiValidationPar)
    {

        $paramDiff = $this->getDiff($data, $apiValidationPar);

        if (sizeof(array_unique($paramDiff)) > 0) {
            $this->errors['malformed_params'] = $paramDiff;
            return false;
        };
        return false;
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
            'mismatch_allowed_params' => implode(',', $paramDiff),
            'unknown_params' => implode(',', $paramInverseDiff)
        );

        return $result;
    }

    private function hasMalformedValues($data, $apiValidationParams)
    {
        foreach ($data as $value) {
            if (in_array($value, $apiValidationParams['forbidden_values'])) {
                $this->errors['invalid_value'][] = $value;
                return true;
            }
        }

        return false;
    }

    public function getErrors()
    {
        return $this->errors;
    }

}
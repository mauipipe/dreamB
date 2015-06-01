<?php
/**
 * Created by David Contavalli <david.contavalli@gmail.com>
 */

namespace API\Controller;


use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

abstract class AbstractBaseRestController extends AbstractRestfulController{

    protected function processRequestParams(array $data, $allowedEmpty = false){
        $response = $this->getResponse();
        if (!$this->restParamsValidator()->isValid($data,$allowedEmpty)) {
            $response->setStatusCode(422);
            return new JsonModel($this->restParamsValidator()->getErrors());
        };
    }

}
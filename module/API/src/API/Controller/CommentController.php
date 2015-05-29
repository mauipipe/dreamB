<?php

namespace API\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class CommentController extends AbstractRestfulController
{

    public function create($data){
        return new JsonModel(array());
    }

}

<?php
namespace API\Controller;
/**
 * Created by David Contavalli <david.contavalli@gmail.com>
 */

use Zend\View\Model\ViewModel,
    Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

}
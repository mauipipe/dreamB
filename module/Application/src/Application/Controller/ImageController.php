<?php

namespace Application\Controller;

use HtImgModule\View\Model\ImageModel;
use Imagine\Gd\Imagine;
use Zend\Mvc\Controller\AbstractActionController;

class ImageController extends AbstractActionController
{
    private $imagine;
    private $imagePath;

    public function __construct($imagePath, Imagine $imagine)
    {
        $this->imagine = $imagine;
        $this->imagePath = $imagePath;
    }

    public function commentAction()
    {

        $imageFile = $this->params('image_file');


        $fullImagePath = $this->imagePath . '/' . $imageFile;
        $image = $this->imagine->open($fullImagePath);

        return new ImageModel($image);
    }

}

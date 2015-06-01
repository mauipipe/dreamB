<?php

namespace Application\Service;

use Zend\File\Transfer\Adapter\Http;

class ImageService
{
    private $httpAdapter;
    private $defaultImagePath;

    const DEFAULT_EXTENSION = '.jpg';

    public function __construct(Http $httpAdapter,$defaultImagePath){
        $this->httpAdapter = $httpAdapter;
        $this->defaultImagePath = $defaultImagePath;
    }

    public function rename($fileName){
        $this->httpAdapter->addFilter('rename', array(
                'target'    => $this->defaultImagePath . '/' . $fileName . self::DEFAULT_EXTENSION,
                'overwrite' => false
            )
        );
        return $this;
    }

    public function isReceived($fileName){
        return $this->httpAdapter->receive($fileName);
    }


}

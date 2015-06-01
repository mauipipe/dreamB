<?php

namespace Spec\Application\Service;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Zend\File\Transfer\Adapter\Http;

class ImageServiceSpec extends ObjectBehavior
{

    const PATH_EXAMPLE = 'path_example';

    public function let(Http $httpAdapter)
    {
        $this->beConstructedWith($httpAdapter, self::PATH_EXAMPLE);
    }

    public function it_set_the_renaming_filer(
        Http $httpAdapter
    )
    {

        $fileName = 1;
        $filterName = 'rename';
        $filterValues = array(
            'target'    => self::PATH_EXAMPLE . '/' . $fileName . '.jpg',
            'overwrite' => true
        );
        $httpAdapter->addFilter($filterName, $filterValues)->shouldBeCalled();
        $this->rename($fileName);
    }

    public function persist_image_in_file_system(
        Http $httpAdapter
    )
    {
        $fileName = 'test.jpg';
        $response = true;
        $httpAdapter->receive($fileName)->shoulBeCalled()->willReturn($response);
        $this->isReceived($fileName)->shouldReturn($response);
    }


}

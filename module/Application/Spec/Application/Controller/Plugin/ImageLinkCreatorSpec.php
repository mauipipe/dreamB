<?php

namespace Spec\Application\Controller\Plugin;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImageLinkCreatorSpec extends ObjectBehavior
{
    function it_extends_abstract_plugin()
    {
        $this->shouldHaveType('Zend\Mvc\Controller\Plugin\AbstractPlugin');
    }

    function it_add_an_image_link_to_the_comment_response()
    {

        $mockComments = array(
            "id"   => 1,
            "name" => "prova"
        );

        $expectedResult = array(
            "id"    => 1,
            "name"  => "prova",
            "image" => "http://localhost/image/comment/1.jpg"
        );

        $this->addFlatsFields(array($mockComments))->shouldBeEqualTo(array($expectedResult));
    }

}

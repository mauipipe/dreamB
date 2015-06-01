<?php
/**
 * Created by David Contavalli <david.contavalli@gmail.com>
 */

namespace API\Validator;


use Zend\InputFilter\InputFilter;

class CommentInputFilter extends InputFilter
{

    public function __construct()
    {

        $this->add(array(
            'name'       => 'name',
            'required'   => true,
            'filters'    => array(
                array('name' => 'StringTrim'),
                array('name' => 'StripTags'),
            ),
            'validators' => array(
                array(
                    'name' => 'not_empty',
                ),
            ),
        ));

        $this->add(array(
            'name'       => 'lastName',
            'required'   => true,
            'filters'    => array(
                array('name' => 'StringTrim'),
                array('name' => 'StripTags')
            ),
            'validators' => array(
                array('name' => 'not_empty'),
            ),
        ));

        $this->add(array(
            'name'       => 'description',
            'required'   => true,
            'filters'    => array(
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array('name' => 'not_empty'),
                array(
                    'name'    => 'string_length',
                    'options' => array(
                        'max' => 255
                    )
                ),
            ),
        ));

        $this->add(array(
            'name'       => 'description',
            'required'   => true,
            'filters'    => array(
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array('name' => 'not_empty'),
                array(
                    'name'    => 'string_length',
                    'options' => array(
                        'max' => 255
                    )
                ),
            ),
        ));
    }
}
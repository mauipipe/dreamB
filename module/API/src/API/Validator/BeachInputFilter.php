<?php
/**
 * Created by David Contavalli <david.contavalli@gmail.com>
 */

namespace API\Validator;


use Zend\InputFilter\InputFilter;

class BeachInputFilter extends InputFilter
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
            'name'       => 'city_id',
            'required'   => true,
            'filters'    => array(
                array('name' => 'StringTrim'),
                array('name' => 'StripTags')
            ),
            'validators' => array(
                array('name' => 'not_empty'),
            ),
        ));
    }
}
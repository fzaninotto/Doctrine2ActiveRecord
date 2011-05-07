<?php

namespace Propel\Tests\Builder;

use Propel\Util\ArrayType;

class ArrayTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testStringifyHandlesValueType()
    {
        $input = array('id' => true, 'name' => 'foo', 'size' => 12);
        $output = ArrayType::stringify($input, 4);
        $expected = "array(
    'id'   => true,
    'name' => 'foo',
    'size' => 12,
)";
        $this->assertEquals($expected, $output);
    }

    public static function stringifyAlignsKeyValuePairsProvider()
    {
        return array(
            array(array('a' => true), "array('a' => true)"),
            array(array('a' => true, 'ab' => true), "array(
    'a'  => true,
    'ab' => true,
)"),
            array(array('a' => true, 'ab' => true, 'abc' => true), "array(
    'a'   => true,
    'ab'  => true,
    'abc' => true,
)"),
            array(array('abc' => true, 'ab' => true, 'a' => true), "array(
    'abc' => true,
    'ab'  => true,
    'a'   => true,
)"),
        );
    }

    /**
     * @dataProvider stringifyAlignsKeyValuePairsProvider
     */
    public function testStringifyAlignsKeyValuePairs($input, $expected)
    {
        $output = ArrayType::stringify($input, 4);
        $this->assertEquals($expected, $output);
    }

    public static function stringifyInlineIfSingleValueProvider()
    {
        $data = array();
        $i = 0;

        $data[0][] = array(
            'postLoad' => array(
                'loading'
            ),
        );
        $data[0][] = <<< 'NOWDOC'
array('postLoad' => array('loading'))
NOWDOC;

        $data[1][] = array(
            'postLoad' => array(
                'loading'
            ),
            'preRemove' => array(
                'willBeRemoved'
            ),
        );
        $data[1][] = <<< 'NOWDOC'
array(
    'postLoad'  => array('loading'),
    'preRemove' => array('willBeRemoved'),
)
NOWDOC;

        $data[2][] = array(
            'name' => 'book_comment',
            'joinColumns' => array(
                array(
                    'name' => 'book_id',
                    'referencedColumnName' => 'id',
                ),
            ),
            'inverseJoinColumns' => array(
                array(
                    'name' => 'comment_id',
                    'referencedColumnName' => 'id',
                ),
            ),
        );
        $data[2][] = <<< 'NOWDOC'
array(
    'name'               => 'book_comment',
    'joinColumns'        => array(array(
        'name'                 => 'book_id',
        'referencedColumnName' => 'id',
    )),
    'inverseJoinColumns' => array(array(
        'name'                 => 'comment_id',
        'referencedColumnName' => 'id',
    )),
)
NOWDOC;

        $data[3][] = array(
            'colors' => array(
                'blue',
                'green',
                'red',
            ),
        );
        $data[3][] = <<< 'NOWDOC'
array('colors' => array(
    'blue',
    'green',
    'red',
))
NOWDOC;

        $data[4][] = array(
            'colors' => array(
                0 => 'blue',
                1 => 'green',
                2 => 'red',
            ),
        );
        $data[4][] = <<< 'NOWDOC'
array('colors' => array(
    'blue',
    'green',
    'red',
))
NOWDOC;

        $data[5][] = array(
            'colors' => array(
                0 => 'blue',
                4 => 'green',
                1 => 'red',
            ),
        );
        $data[5][] = <<< 'NOWDOC'
array('colors' => array(
    0 => 'blue',
    4 => 'green',
    1 => 'red',
))
NOWDOC;

        $data[6][] = array(
            'fieldName'         => 'comments',
            'targetEntity'      => 'Doctrine\Tests\ORM\Tools\EntityGeneratorComment',
            'cascade'           => array(),
            'fetch'             => \Doctrine\ORM\Mapping\ClassMetadata::FETCH_LAZY,
            'joinTable'         => array(
                'name'               => 'book_comment',
                'joinColumns'        => array(array(
                    'name'                 => 'book_id',
                    'referencedColumnName' => 'id',
                )),
                'inverseJoinColumns' => array(array(
                    'name'                 => 'comment_id',
                    'referencedColumnName' => 'id',
                )),
            ),
        );
        $data[6][] = <<< 'NOWDOC'
array(
    'fieldName'    => 'comments',
    'targetEntity' => 'Doctrine\\Tests\\ORM\\Tools\\EntityGeneratorComment',
    'cascade'      => array(),
    'fetch'        => 2,
    'joinTable'    => array(
        'name'               => 'book_comment',
        'joinColumns'        => array(array(
            'name'                 => 'book_id',
            'referencedColumnName' => 'id',
        )),
        'inverseJoinColumns' => array(array(
            'name'                 => 'comment_id',
            'referencedColumnName' => 'id',
        )),
    ),
)
NOWDOC;

        return $data;
    }

    /**
     * @dataProvider stringifyInlineIfSingleValueProvider
     */
    public function testStringifyInlineIfSingleValue($input, $expected)
    {
        $output = ArrayType::stringify($input, 4);
        $this->assertEquals($expected, $output);
    }

}
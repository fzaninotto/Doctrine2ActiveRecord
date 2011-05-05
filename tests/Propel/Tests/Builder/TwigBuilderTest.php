<?php

namespace Propel\Tests\Builder;

use Propel\Builder\TwigBuilder;

class TwigBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testExportArrayHandlesValueType()
    {
        $input = array('id' => true, 'name' => 'foo', 'size' => 12);
        $output = TwigBuilder::exportArray($input, 4);
        $expected = "array(
    'id'   => true,
    'name' => 'foo',
    'size' => 12,
)";
        $this->assertEquals($expected, $output);
    }
    
    public static function exportArrayAlignsKeyValuePairsProvider()
    {
        return array(
            array(array('a' => true), "array(
    'a' => true,
)"),
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
     * @dataProvider exportArrayAlignsKeyValuePairsProvider
     */
    public function testExportArrayAlignsKeyValuePairs($input, $expected)
    {
        $output = TwigBuilder::exportArray($input, 4);
        $this->assertEquals($expected, $output);
    }
}
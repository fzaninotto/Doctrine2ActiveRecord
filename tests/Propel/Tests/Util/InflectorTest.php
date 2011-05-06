<?php

namespace Propel\Tests\Util;

use Propel\Util\Inflector;

class InflectorTest extends \PHPUnit_Framework_TestCase
{
    public static function singularizeProvider()
    {
        return array(
            array('books', 'book'),
            array('men', 'man'),
            array('entities', 'entity'),
            array('people', 'person'),
            array('fish', 'fish'),
            array('wives', 'wife'),
        );
    }

    /**
     * @dataProvider singularizeProvider
     */
    public function testSingularize($plural, $singular)
    {
        $this->assertEquals($singular, Inflector::singularize($plural));
    }
}
<?php
use Verona\Value\DateValue;

/**
 * Created by PhpStorm.
 * User: Nathan
 * Date: 25/01/2016
 * Time: 10:55
 */
class DateValueTest extends PHPUnit_Framework_TestCase
{


    public function testOnlyDate()
    {

        $exampleOne = new DateValue('2015-01-01 10:15:32');
        $exampleTwo = new DateValue('2015-01-01 15:15:15');

        $this->assertEquals($exampleOne, $exampleTwo);

    }
}

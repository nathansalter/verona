<?php
use Verona\Value\AbstractEnumValue;

/**
 * Created by PhpStorm.
 * User: Nathan
 * Date: 25/01/2016
 * Time: 10:42
 */
class AbstractEnumValueTest extends PHPUnit_Framework_TestCase
{

    public function testWithConstants()
    {

        $expectedA = 'A';
        $expectedB = 'B';

        /** @var AbstractEnumValue $class */
        $class = (new class($expectedB) extends AbstractEnumValue {
            const A = 'A';
            const B = 'B';
        });

        $this->assertEquals($expectedB, $class->get());

        try {
            $class->set('FAIL');
            $this->fail('Should not have reached this expression');
        } catch (Exception $e) {}

        $this->assertEquals([$expectedA, $expectedB], $class->getOptions());

        $class->set($expectedA);
        $this->assertEquals($expectedA, $class->get());

    }
}

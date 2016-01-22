<?php
use Verona\Item\AbstractItem;

/**
 * Created by PhpStorm.
 * User: Nathan
 * Date: 22/01/2016
 * Time: 12:12
 */
class AbstractItemTest extends PHPUnit_Framework_TestCase
{


    public function testGenerateId()
    {
        /** @var AbstractItem $abstractItem */
        $abstractItem = $this->getMockForAbstractClass(AbstractItem::class);


        $id = $abstractItem->getId();

        $this->assertEquals(AbstractItem::DEFAULT_ID_LENGTH, strlen($id));

        /** @var AbstractItem $newAbstractItem */
        $newAbstractItem = $this->getMockForAbstractClass(AbstractItem::class);

        $this->assertNotEquals($id, $newAbstractItem->getId());

        $expectedId = 'rawr';
        $this->assertInstanceOf(AbstractItem::class, $abstractItem->setId($expectedId));
        $this->assertEquals($expectedId, $abstractItem->getId());

    }

    public function testExchangeable()
    {

        /** @var AbstractItem $item */
        $item = $this->getMockForAbstractClass(AbstractItem::class);
        /** @var AbstractItem $newItem */
        $newItem = $this->getMockForAbstractClass(AbstractItem::class);

        $conf = $item->toArray();
        $newItem->fromArray($conf);

        $this->assertEquals($conf, $newItem->toArray());

    }


}

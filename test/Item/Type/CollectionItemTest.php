<?php
use Verona\Item\ItemInterface;
use Verona\Item\Type\CollectionItem;

/**
 * Created by PhpStorm.
 * User: Nathan
 * Date: 21/01/2016
 * Time: 08:52
 */
class CollectionItemTest extends PHPUnit_Framework_TestCase
{

    public function testGettersAndSetters()
    {
        $collectionItem = new CollectionItem();

        $expectedName = 'rawr';

        $this->assertFalse($collectionItem->hasName());
        $this->assertInstanceOf(CollectionItem::class, $collectionItem->setName($expectedName));
        $this->assertTrue($collectionItem->hasName());
        $this->assertEquals($expectedName, $collectionItem->getName());

        $expectedItemA = $this->getMock(ItemInterface::class);
        $expectedItemA->method('getId')->willReturn('A');

        $expectedItemB = $this->getMock(ItemInterface::class);
        $expectedItemB->method('getId')->willReturn('B');

        $unexpectedItem = $this->getMock(ItemInterface::class);
        $unexpectedItem->method('getId')->willReturn('C');

        $this->assertInstanceOf(CollectionItem::class, $collectionItem->add($expectedItemA));
        $collectionItem->add($expectedItemB)
            ->add($unexpectedItem);

        $this->assertTrue($collectionItem->has('A'));
        $this->assertTrue($collectionItem->has('B'));
        $this->assertTrue($collectionItem->has('C'));

        $this->assertInstanceOf(CollectionItem::class, $collectionItem->remove('C'));
        $this->assertFalse($collectionItem->has('C'));

        $this->assertEquals(2, $collectionItem->count());

        $count = 0;
        foreach($collectionItem as $testItem) {
            $count++;
            $this->assertContains($testItem, [$expectedItemA, $expectedItemB]);
        }

        $this->assertEquals(2, $count, 'Foreach loop did not run expected number of times');

    }

}

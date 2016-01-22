<?php
use Verona\Item\ItemInterface;
use Verona\Item\Type\ActionItem;
use Verona\Item\Type\UserItem;
use Verona\Value\ActionTypeValue;

/**
 * Created by PhpStorm.
 * User: Nathan
 * Date: 22/01/2016
 * Time: 12:11
 */
class ActionItemTest extends PHPUnit_Framework_TestCase
{


    public function testGettersAndSetters()
    {

        $actionItem = new ActionItem();

        $expectedAction = new ActionTypeValue(ActionTypeValue::CREATE);
        $this->assertFalse($actionItem->hasAction());
        $this->assertInstanceOf(ActionItem::class, $actionItem->setAction($expectedAction));
        $this->assertTrue($actionItem->hasAction());
        $this->assertEquals($expectedAction, $actionItem->getAction());

        $expectedItemId = 'RAWR!';
        $this->assertFalse($actionItem->hasItemId());
        $this->assertInstanceOf(ActionItem::class, $actionItem->setItemId($expectedItemId));
        $this->assertTrue($actionItem->hasItemId());
        $this->assertEquals($expectedItemId, $actionItem->getItemId());

        $expectedUserId = 'RAWRRAWRRAWRRAWR';
        $this->assertFalse($actionItem->hasUserId());
        $this->assertInstanceOf(ActionItem::class, $actionItem->setUserId($expectedUserId));
        $this->assertTrue($actionItem->hasUserId());
        $this->assertEquals($expectedUserId, $actionItem->getUserId());

        $newUser = new UserItem();
        $this->assertInstanceOf(ActionItem::class, $actionItem->setUser($newUser));
        $this->assertEquals($newUser->getId(), $actionItem->getUserId());

        $expectedItem = $this->getMock(ItemInterface::class);
        $this->assertFalse($actionItem->hasItemType());
        $this->assertInstanceOf(ActionItem::class, $actionItem->setItemType($expectedItem));
        $this->assertTrue($actionItem->hasItemType());
        $this->assertInstanceOf(ActionItem::class, $actionItem->setItemTypeString(ActionItem::class));
        $this->assertEquals(ActionItem::class, $actionItem->getItemType());

        $newItem = new ActionItem();
        $this->assertInstanceOf(ActionItem::class, $actionItem->setItem($newItem));
        $this->assertEquals($newItem->getId(), $actionItem->getItemId());
        $this->assertEquals(ActionItem::class, $actionItem->getItemType());

    }

    public function testExchangeable()
    {

        $actionItem = new ActionItem();
        $actionItem->setUserId('rawr')
            ->setAction(new ActionTypeValue(ActionTypeValue::DELETE))
            ->setItemId('Foo')
            ->setItemType(new ActionItem());

        $conf = $actionItem->toArray();

        $newActionItem = new ActionItem();
        $newActionItem->fromArray($conf);

        $this->assertEquals($actionItem, $newActionItem);
        $this->assertEquals($conf, $newActionItem->toArray());

    }


}

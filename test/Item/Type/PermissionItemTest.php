<?php
use Verona\Item\Type\PermissionItem;
use Verona\Item\Type\UserGroupItem;

/**
 * Created by PhpStorm.
 * User: Nathan
 * Date: 25/01/2016
 * Time: 10:15
 */
class PermissionItemTest extends PHPUnit_Framework_TestCase
{


    /**
     * @return PermissionItem
     */
    public function testGettersAndSetters()
    {
        
        $permission = new PermissionItem();

        $expectedItem = new PermissionItem();
        $this->assertFalse($permission->hasItemId());
        $this->assertInstanceOf(PermissionItem::class, $permission->setItem($expectedItem));
        $this->assertEquals($expectedItem->getId(), $permission->getItemId());
        $this->assertTrue($permission->hasItemId());
        $this->assertInstanceOf(PermissionItem::class, $permission->setItemId($expectedItem->getId()));
        $this->assertEquals($expectedItem->getId(), $permission->getItemId());

        $expectedUserGroup = new UserGroupItem();
        $this->assertFalse($permission->hasUserGroupId());
        $this->assertInstanceOf(PermissionItem::class, $permission->setUserGroup($expectedUserGroup));
        $this->assertEquals($expectedUserGroup->getId(), $permission->getUserGroupId());
        $this->assertTrue($permission->hasUserGroupId());
        $this->assertInstanceOf(PermissionItem::class, $permission->setUserGroupId($expectedUserGroup->getId()));
        $this->assertEquals($expectedUserGroup->getId(), $permission->getUserGroupId());
        
        $expectedAllowed = true;
        $this->assertFalse($permission->isAllowed());
        $this->assertInstanceOf(PermissionItem::class, $permission->setAllowed($expectedAllowed));
        $this->assertEquals($expectedAllowed, $permission->isAllowed());

        return $permission;
        
    }

    /**
     * @param PermissionItem $item
     * @depends testGettersAndSetters
     */
    public function testExchangeable(PermissionItem $item)
    {

        $conf = $item->toArray();

        $newItem = new PermissionItem();
        $newItem->fromArray($conf);

        $this->assertEquals($item, $newItem);

        $newConf = $newItem->toArray();

        $this->assertEquals($conf, $newConf);

    }
}

<?php
use Verona\Item\Type\UserGroupItem;

/**
 * Created by PhpStorm.
 * User: Nathan
 * Date: 25/01/2016
 * Time: 10:23
 */
class UserGroupItemTest extends PHPUnit_Framework_TestCase
{

    /**
     * @return UserGroupItem
     */
    public function testGettersAndSetters()
    {

        $userGroup = new UserGroupItem();

        $expectedName = 'rawrderawr';
        $this->assertInstanceOf(UserGroupItem::class, $userGroup->setName($expectedName));
        $this->assertEquals($expectedName, $userGroup->getName());

        return $userGroup;

    }


    /**
     * @param UserGroupItem $userGroup
     * @depends testGettersAndSetters
     */
    public function testExchangeable(UserGroupItem $userGroup)
    {

        $conf = $userGroup->toArray();

        $newUserGroup = new UserGroupItem();
        $newUserGroup->fromArray($conf);

        $this->assertEquals($userGroup, $newUserGroup);

        $newConf = $newUserGroup->toArray();

        $this->assertEquals($conf, $newConf);

    }
}

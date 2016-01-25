<?php
use Verona\Item\Type\UserGroupItem;
use Verona\Item\Type\UserItem;

/**
 * Created by PhpStorm.
 * User: Nathan
 * Date: 25/01/2016
 * Time: 10:27
 */
class UserItemTest extends PHPUnit_Framework_TestCase
{

    /**
     * @return UserItem
     */
    public function testGettersAndSetters()
    {
    
        $user = new UserItem();
        
        $expectedUserGroup = new UserGroupItem();
        $this->assertFalse($user->hasUserGroupId());
        $this->assertInstanceOf(UserItem::class, $user->setUserGroup($expectedUserGroup));
        $this->assertTrue($user->hasUserGroupId());
        $this->assertEquals($expectedUserGroup->getId(), $user->getUserGroupId());
        $this->assertInstanceOf(UserItem::class, $user->setUserGroupId($expectedUserGroup->getId()));
        $this->assertEquals($expectedUserGroup->getId(), $user->getUserGroupId());
        
        $expectedName = 'Great';
        $this->assertFalse($user->hasFirstName());
        $this->assertInstanceOf(UserItem::class, $user->setFirstName($expectedName));
        $this->assertTrue($user->hasFirstName());
        $this->assertEquals($expectedName, $user->getFirstName());
    
        $expectedSurname = 'Scott!';
        $this->assertFalse($user->hasSurname());
        $this->assertInstanceOf(UserItem::class, $user->setSurname($expectedSurname));
        $this->assertTrue($user->hasSurname());
        $this->assertEquals($expectedSurname, $user->getSurname());
        
        return $user;
        
    }

    /**
     * @param UserItem $user
     * @depends testGettersAndSetters
     */
    public function testExchangeable(UserItem $user)
    {

        $conf = $user->toArray();

        $newUser = new UserItem();
        $newUser->fromArray($conf);

        $this->assertEquals($user, $newUser);

        $newConf = $newUser->toArray();

        $this->assertEquals($conf, $newConf);

    }


}

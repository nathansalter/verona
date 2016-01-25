<?php


namespace Verona\Item\Type;


use Verona\Item\AbstractItem;
use Verona\Item\ItemInterface;

class UserItem extends AbstractItem implements SimpleTypeInterface
{

    const EXCHANGE_FIRST_NAME = 'firstName';

    const EXCHANGE_SURNAME = 'surname';

    const EXCHANGE_USER_GROUP_ID = 'groupId';

    const ID_PREFIX = 'USR:';

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $surname;

    /**
     * @var string
     */
    private $userGroupId;

    /**
     * UserItem constructor.
     */
    public function __construct()
    {
        $this->assignId(self::ID_PREFIX);
    }

    /**
     * @return string
     */
    public function getFirstName() : string
    {
        if(! $this->hasFirstName()) {
            throw new \RuntimeException(sprintf('%s() does not have a first name available', __METHOD__));
        }
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return UserItem
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasFirstName() : bool
    {
        return $this->firstName !== null;
    }

    /**
     * @return string
     */
    public function getSurname() : string
    {
        if(! $this->hasSurname()) {
            throw new \RuntimeException(sprintf('%s() does not have a surname available', __METHOD__));
        }
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return UserItem
     */
    public function setSurname(string $surname) : UserItem
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasSurname() : bool
    {
        return $this->surname !== null;
    }

    /**
     * @return string
     */
    public function getUserGroupId() : string
    {
        if(! $this->hasUserGroupId()) {
            throw new \RuntimeException(sprintf('%s() does not have a user group id available', __METHOD__));
        }
        return $this->userGroupId;
    }

    /**
     * @param string $userGroupId
     * @return UserItem
     */
    public function setUserGroupId(string $userGroupId) : UserItem
    {
        $this->userGroupId = $userGroupId;
        return $this;
    }

    /**
     * @param UserGroupItem $userGroup
     * @return UserItem
     */
    public function setUserGroup(UserGroupItem $userGroup) : UserItem
    {
        $this->setUserGroupId($userGroup->getId());
        return $this;
    }

    /**
     * @return bool
     */
    public function hasUserGroupId() : bool
    {
        return $this->userGroupId !== null;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return array_merge([
            self::EXCHANGE_FIRST_NAME => $this->getFirstName(),
            self::EXCHANGE_SURNAME => $this->getSurname(),
            self::EXCHANGE_USER_GROUP_ID => $this->getUserGroupId()
        ], parent::toArray());
    }

    /**
     * @param array $data
     * @return ItemInterface
     */
    public function fromArray(array $data) : ItemInterface
    {
        parent::fromArray($data);

        if(isset($data[self::EXCHANGE_FIRST_NAME])) {
            $this->setFirstName($data[self::EXCHANGE_FIRST_NAME]);
        }

        if(isset($data[self::EXCHANGE_SURNAME])) {
            $this->setSurname($data[self::EXCHANGE_SURNAME]);
        }

        if(isset($data[self::EXCHANGE_USER_GROUP_ID])) {
            $this->setUserGroupId($data[self::EXCHANGE_USER_GROUP_ID]);
        }

        return $this;
    }


}
<?php


namespace Verona\Item\Type;


use Verona\Item\AbstractItem;
use Verona\Item\ItemInterface;

class PermissionItem extends AbstractItem implements SimpleTypeInterface
{

    const EXCHANGE_USER_GROUP_ID = 'userGroup';

    const EXCHANGE_ITEM_ID = 'item';

    const EXCHANGE_ALLOWED = 'allowed';

    const ID_PREFIX = 'PER:';

    /**
     * @var string
     */
    private $userGroupId;

    /**
     * @var string
     */
    private $itemId;

    /**
     * @var bool
     */
    private $allowed;

    public function __construct()
    {
        $this->assignId(self::ID_PREFIX);
    }

    /**
     * @return string
     */
    public function getUserGroupId() : string
    {
        if (!$this->hasUserGroupId()) {
            throw new \RuntimeException(sprintf('%s() does not have a user group id available', __METHOD__));
        }
        return $this->userGroupId;
    }

    public function hasUserGroupId() : bool
    {
        return $this->userGroupId !== null;
    }

    /**
     * @param string $userGroupId
     * @return PermissionItem
     */
    public function setUserGroupId(string $userGroupId) : PermissionItem
    {
        $this->userGroupId = $userGroupId;
        return $this;
    }

    public function setUserGroup(UserGroupItem $userGroup) : PermissionItem
    {
        $this->setUserGroupId($userGroup->getId());
        return $this;
    }

    /**
     * @return string
     */
    public function getItemId() : string
    {
        if (!$this->hasItemId()) {
            throw new \RuntimeException(sprintf('%s() does not have an item ID available', __METHOD__));
        }
        return $this->itemId;
    }

    /**
     * @return bool
     */
    public function hasItemId() : bool
    {
        return $this->itemId !== null;
    }

    /**
     * @param string $itemId
     * @return PermissionItem
     */
    public function setItemId(string $itemId) : PermissionItem
    {
        $this->itemId = $itemId;
        return $this;
    }

    public function setItem(ItemInterface $item) : PermissionItem
    {
        $this->setItemId($item->getId());
        return $this;
    }

    /**
     * @return boolean
     */
    public function isAllowed() : bool
    {
        return $this->allowed ? true : false;
    }

    /**
     * @param boolean $allowed
     * @return PermissionItem
     */
    public function setAllowed(bool $allowed) : PermissionItem
    {
        $this->allowed = $allowed;
        return $this;
    }

    public function toArray() : array
    {
        return array_merge([
            self::EXCHANGE_USER_GROUP_ID => $this->getUserGroupId(),
            self::EXCHANGE_ITEM_ID => $this->getItemId(),
            self::EXCHANGE_ALLOWED => $this->isAllowed()
        ], parent::toArray());
    }

    public function fromArray(array $data) : ItemInterface
    {
        parent::fromArray($data);

        if (isset($data[self::EXCHANGE_USER_GROUP_ID])) {
            $this->setUserGroupId($data[self::EXCHANGE_USER_GROUP_ID]);
        }

        if (isset($data[self::EXCHANGE_ITEM_ID])) {
            $this->setItemId($data[self::EXCHANGE_ITEM_ID]);
        }

        if (isset($data[self::EXCHANGE_ALLOWED])) {
            $this->setAllowed($data[self::EXCHANGE_ALLOWED]);
        }

        return $this;
    }


}
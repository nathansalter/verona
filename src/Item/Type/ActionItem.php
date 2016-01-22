<?php


namespace Verona\Item\Type;


use Verona\Item\AbstractItem;
use Verona\Item\ItemInterface;
use Verona\Value\ActionTypeValue;

/**
 * This class defines an action performed in the system between a user and any other item
 *
 * Class ActionItem
 * @package Verona\Item\Type
 */
class ActionItem extends AbstractItem implements SimpleTypeInterface
{

    const EXCHANGE_USER_ID = 'userId';

    const EXCHANGE_ITEM_TYPE = 'itemType';

    const EXCHANGE_ITEM_ID = 'itemId';

    const EXCHANGE_ACTION_TYPE = 'actionType';

    const ID_PREFIX = 'ACT:';

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $itemType;

    /**
     * @var string
     */
    private $itemId;

    /**
     * @var ActionTypeValue
     */
    private $action;

    /**
     * ActionItem constructor.
     */
    public function __construct()
    {
        $this->assignId(self::ID_PREFIX);
    }

    /**
     * @return string
     */
    public function getUserId() : string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     * @return ActionItem
     */
    public function setUserId(string $userId) : ActionItem
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @param UserItem $user
     * @return ActionItem
     */
    public function setUser(UserItem $user) : ActionItem
    {
        $this->setUserId($user->getId());
        return $this;
    }

    /**
     * @return bool
     */
    public function hasUserId() : bool
    {
        return $this->userId !== null;
    }

    /**
     * @return string
     */
    public function getItemType() : string
    {
        return $this->itemType;
    }

    /**
     * @param ItemInterface $itemType
     * @return ActionItem
     */
    public function setItemType(ItemInterface $itemType) : ActionItem
    {
        $this->itemType = get_class($itemType);
        return $this;
    }

    /**
     * @param string $itemType
     * @return ActionItem
     */
    public function setItemTypeString(string $itemType) : ActionItem
    {
        if(! is_subclass_of($itemType, ItemInterface::class)) {
            throw new \RuntimeException(sprintf('%s() Cannot accept a non-item interface type class', __METHOD__));
        }
        $this->itemType = $itemType;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasItemType() : bool
    {
        return $this->itemType !== null;
    }

    /**
     * @return string
     */
    public function getItemId() : string
    {
        return $this->itemId;
    }

    /**
     * @param string $itemId
     * @return ActionItem
     */
    public function setItemId(string $itemId) : ActionItem
    {
        $this->itemId = $itemId;
        return $this;
    }

    /**
     * @param ItemInterface $item
     * @return ActionItem
     */
    public function setItem(ItemInterface $item) : ActionItem
    {
        $this->setItemId($item->getId())
            ->setItemType($item);
        return $this;
    }

    /**
     * @return bool
     */
    public function hasItemId() : bool
    {
        return $this->itemId !== null;
    }

    /**
     * @return ActionTypeValue
     */
    public function getAction() : ActionTypeValue
    {
        return $this->action;
    }

    /**
     * @return bool
     */
    public function hasAction() : bool
    {
        return $this->action instanceof ActionTypeValue;
    }

    /**
     * @param ActionTypeValue $action
     * @return ActionItem
     */
    public function setAction(ActionTypeValue $action) : ActionItem
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return array_merge(
            array_filter([
                self::EXCHANGE_USER_ID => $this->hasUserId() ? $this->getUserId() : null,
                self::EXCHANGE_ITEM_ID => $this->hasItemId() ? $this->getItemId() : null,
                self::EXCHANGE_ITEM_TYPE => $this->hasItemType() ? $this->getItemType() : null,
                self::EXCHANGE_ACTION_TYPE => $this->hasAction() ? $this->getAction()->get() : null
            ]),
            parent::toArray()
        );
    }

    /**
     * @param array $data
     * @return ItemInterface
     */
    public function fromArray(array $data) : ItemInterface
    {
        parent::fromArray($data);

        if (isset($data[self::EXCHANGE_USER_ID])) {
            $this->setUserId($data[self::EXCHANGE_USER_ID]);
        }

        if (isset($data[self::EXCHANGE_ITEM_ID])) {
            $this->setItemId($data[self::EXCHANGE_ITEM_ID]);
        }

        if (isset($data[self::EXCHANGE_ITEM_TYPE])) {
            $type = $data[self::EXCHANGE_ITEM_TYPE];

            if ($type instanceof ItemInterface) {
                $this->setItemType($type);
            } else {
                $this->setItemTypeString($type);
            }
        }

        if (isset($data[self::EXCHANGE_ACTION_TYPE])) {
            $action = $data[self::EXCHANGE_ACTION_TYPE];

            if (!$action instanceof ActionTypeValue) {
                $action = new ActionTypeValue($action);
            }

            $this->setAction($action);
        }

        return $this;

    }


}
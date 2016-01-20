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
     * @var ItemInterface
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
     * @return bool
     */
    public function hasUserId() : bool
    {
        return $this->userId !== null;
    }

    /**
     * @return ItemInterface
     */
    public function getItemType() : ItemInterface
    {
        return $this->itemType;
    }

    /**
     * @param ItemInterface $itemType
     * @return ActionItem
     */
    public function setItemType(ItemInterface $itemType) : ActionItem
    {
        $this->itemType = $itemType;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasItemType() : bool
    {
        return $this->itemType instanceof ItemInterface;
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
                self::EXCHANGE_ITEM_TYPE => $this->hasItemType() ? get_class($this->getItemType()) : null,
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

            if (!$type instanceof ItemInterface) {
                $type = new $type;
            }

            $this->setItemType($type);
        }

        if (isset($data[self::EXCHANGE_ACTION_TYPE])) {
            $action = $data[self::EXCHANGE_ITEM_TYPE];

            if (!$action instanceof ActionTypeValue) {
                $action = new ActionTypeValue($action);
            }

            $this->setAction($action);
        }

        return $this;

    }


}
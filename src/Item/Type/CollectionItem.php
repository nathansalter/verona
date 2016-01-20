<?php


namespace Verona\Item\Type;


use Verona\Item\AbstractItem;
use Verona\Item\ItemInterface;

class CollectionItem extends AbstractItem implements \Countable, \IteratorAggregate, TreeTypeInterface
{

    const EXCHANGE_NAME = 'name';

    const EXCHANGE_ITEMS = 'items';

    const EXCHANGE_ITEM_TYPE = 'type';

    const EXCHANGE_ITEM_DATA = 'data';

    const ID_PREFIX = 'COL:';

    /**
     * @var ItemInterface[]
     */
    private $items;

    /**
     * @var string
     */
    private $name;

    /**
     * CollectionItem constructor.
     */
    public function __construct()
    {
        $this->assignId(self::ID_PREFIX);
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        if (!$this->hasName()) {
            throw new \RuntimeException(sprintf('%s() does not have a name available', __METHOD__));
        }
        return $this->name;
    }

    /**
     * @return bool
     */
    public function hasName() : bool
    {
        return $this->name !== null;
    }

    /**
     * @param string $name
     * @return CollectionItem
     */
    public function setName(string $name) : CollectionItem
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @param ItemInterface $item
     * @return TreeTypeInterface
     */
    public function add(ItemInterface $item) : TreeTypeInterface
    {
        if (!$this->has($item->getId())) {
            $this->items[$item->getId()] = $item;
        }

        return $this;
    }

    /**
     * @param string $itemId
     * @return CollectionItem
     */
    public function has(string $itemId) : CollectionItem
    {
        return isset($this->items[$itemId]);
    }

    /**
     * @param string $itemId
     * @return ItemInterface
     */
    public function get(string $itemId) : ItemInterface
    {
        if (!$this->has($itemId)) {
            throw new \RuntimeException(sprintf('%s(%s) did not contain the item with the given ID', __METHOD__, $itemId));
        }
        return $this->items[$itemId];
    }

    /**
     * @return array
     */
    public function getAll() : array
    {
        return $this->items;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->getAll());
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->getAll());
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return array_merge([
            self::EXCHANGE_ITEMS => array_map(function (ItemInterface $item) {
                return [
                    self::EXCHANGE_ITEM_TYPE => get_class($item),
                    self::EXCHANGE_ITEM_DATA => $item->toArray()
                ];
            }, $this->getAll())
        ], $this->getBaseConfig());
    }

    public function getBaseConfig() : array
    {
        return array_merge([
            self::EXCHANGE_NAME => $this->getName()
        ], parent::toArray());
    }

    /**
     * @param array $data
     * @return ItemInterface
     */
    public function fromArray(array $data) : ItemInterface
    {
        parent::fromArray($data);

        if (isset($data[self::EXCHANGE_NAME])) {
            $this->setName($data[self::EXCHANGE_NAME]);
        }

        if (isset($data[self::EXCHANGE_ITEMS])) {
            foreach ($data[self::EXCHANGE_ITEMS] as $itemConf) {
                $item = $itemConf;

                if (!$item instanceof ItemInterface) {

                    //Check for attacks
                    if (!is_subclass_of($itemConf[self::EXCHANGE_ITEM_TYPE], ItemInterface::class)) {
                        throw new \RuntimeException(sprintf('%s() got an invalid class type: %s', __METHOD__, $itemConf[self::EXCHANGE_ITEM_TYPE]));
                    }

                    /** @var ItemInterface $item */
                    $item = new $itemConf[self::EXCHANGE_ITEM_TYPE];
                    $item->fromArray($itemConf[self::EXCHANGE_ITEM_DATA]);
                }

                $this->add($item);

            }
        }

        return $this;

    }


}
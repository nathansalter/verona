<?php


namespace Verona\Item;


trait ItemFactoryAwareTrait
{

    /**
     * @var ItemFactoryInterface
     */
    private $itemFactory;

    /**
     * @return ItemFactoryInterface
     */
    public function getItemFactory() : ItemFactoryInterface
    {
        if (!$this->hasItemFactory()) {
            throw new \RuntimeException(sprintf('%s() does not have an item factory available', __METHOD__));
        }
        return $this->itemFactory;
    }

    public function hasItemFactory() : bool
    {
        return $this->itemFactory instanceof ItemFactoryInterface;
    }

    /**
     * @param ItemFactoryInterface $itemFactory
     * @return $this
     */
    public function setItemFactory($itemFactory)
    {
        $this->itemFactory = $itemFactory;
        return $this;
    }

}
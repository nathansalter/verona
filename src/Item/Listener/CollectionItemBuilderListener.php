<?php


namespace Verona\Item\Listener;


use Verona\Item\AbstractItem;
use Verona\Item\ItemFactoryAwareTrait;
use Verona\Item\ItemFactoryEvent;
use Verona\Item\ItemFactoryEvents;
use Verona\Item\ItemFactoryInterface;
use Verona\Item\ItemInterface;
use Verona\Item\Type\TreeTypeInterface;
use Verona\Store\StorageAwareTrait;
use Verona\Store\StorageInterface;
use Verona\Timetable\TimetableManagerAwareTrait;
use Verona\Timetable\TimetableManagerInterface;

class CollectionItemBuilderListener
{
    use StorageAwareTrait,
        TimetableManagerAwareTrait,
        ItemFactoryAwareTrait;

    const ITEM_CONFIG_KEY = 'items';
    const SUB_ID = 'id';
    const SUB_TYPE = 'type';

    public function __construct(StorageInterface $store, TimetableManagerInterface $timetableManager, ItemFactoryInterface $itemFactory)
    {
        $this->setStorage($store)
            ->setTimetableManager($timetableManager)
            ->setItemFactory($itemFactory);
    }

    private function getType(ItemInterface $item)
    {
        // Work out the Type Name
        $class = get_class($item);
        $type = substr($class, strrpos($class, '/') + 1);
        return $type;
    }

    public function prepareItem(ItemFactoryEvent $event)
    {
        $item = $event->getItem();
        if ($item instanceof TreeTypeInterface) {
            $itemId = $item->getId();
            $type = $this->getType($item);
            $conf = $this->getStorage()->get($type, $itemId, $this->getTimetableManager()->getPointInTime());

            foreach ($conf[self::ITEM_CONFIG_KEY] as $subItemConf) {
                /** @var AbstractItem $subItem */
                $subItem = new $subItemConf[self::SUB_TYPE]();
                $subItem->setId($subItemConf[self::SUB_ID]);
                $item->add($subItem);
            }
            unset($conf[self::ITEM_CONFIG_KEY]);

            $item->fromArray($conf);

        }
    }

    public function storeItem(ItemFactoryEvent $event)
    {
        $item = $event->getItem();
        if ($item instanceof TreeTypeInterface) {

            $itemId = $item->getId();
            $type = $this->getType($item);
            $conf = $item->getBaseConfig();

            foreach ($item->getAll() as $subItem) {
                $this->getItemFactory()->storeItem($subItem);
            }

            $this->getStorage()->store($type, $itemId, $conf);

        }
    }

    public function getSubscribedEvents() : array
    {
        return [
            ItemFactoryEvents::PREPARE_ITEM => [$this, 'prepareItem'],
            ItemFactoryEvents::STORE_ITEM => [$this, 'storeItem']
        ];
    }
}
<?php


namespace Verona\Item\Listener;


use Verona\Event\EventSubscriberInterface;
use Verona\Item\ItemFactoryEvent;
use Verona\Item\ItemFactoryEvents;
use Verona\Item\ItemInterface;
use Verona\Item\Type\SimpleTypeInterface;
use Verona\Store\StorageAwareTrait;
use Verona\Store\StorageInterface;
use Verona\Timetable\TimetableManagerAwareTrait;
use Verona\Timetable\TimetableManagerInterface;

class ItemBuilderListener implements EventSubscriberInterface
{

    use StorageAwareTrait,
        TimetableManagerAwareTrait;

    public function __construct(StorageInterface $store, TimetableManagerInterface $timetableManager)
    {
        $this->setStorage($store)
            ->setTimetableManager($timetableManager);
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
        if ($event->getItem() instanceof SimpleTypeInterface) {
            // Get the ID
            $itemId = $event->getItem()->getId();
            $type = $this->getType($event->getItem());
            // Get the configuration from the store
            $config = $this->getStorage()->get($type, $itemId, $this->getTimetableManager()->getPointInTime());
            // Update the item with the config
            $event->getItem()->fromArray($config);
        }
    }

    public function storeItem(ItemFactoryEvent $event)
    {
        if ($event->getItem() instanceof SimpleTypeInterface) {
            $itemId = $event->getItem()->getId();
            $type = $this->getType($event->getItem());
            $conf = $event->getItem()->toArray();

            $this->getStorage()->store($itemId, $type, $conf);
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
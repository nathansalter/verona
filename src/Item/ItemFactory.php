<?php

namespace Verona\Item;

use Verona\Event\EventSubscriberInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\EventManager\EventManagerInterface;

class ItemFactory implements ItemFactoryInterface, EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    /**
     *
     * @param array $subscribers
     * @param EventManagerInterface $eventManager
     */
    public function __construct(array $subscribers, EventManagerInterface $eventManager = null)
    {
        if ($eventManager instanceof EventManagerInterface) {
            $this->setEventManager($eventManager);
        }

        foreach ($subscribers as $subscriber) {

            if ($subscriber instanceof EventSubscriberInterface) {
                foreach ($subscriber->getSubscribedEvents() as $event => $callable) {
                    $this->getEventManager()->attach($event, $callable);
                }
            }

        }
    }


    /**
     *
     * {@inheritDoc}
     * @see \Verona\Item\ItemFactoryInterface::getItem($name)
     */
    public function getItem(ItemInterface $itemPrototype) : ItemInterface
    {

        $event = new ItemFactoryEvent();
        $event->setItem($itemPrototype)
            ->setName(ItemFactoryEvents::PREPARE_ITEM);

        $this->getEventManager()->trigger($event, $this);

        return $event->getItem();

    }

    public function storeItem(ItemInterface $item) : ItemFactoryInterface
    {
        $event = new ItemFactoryEvent();
        $event->setItem($item)
            ->setName(ItemFactoryEvents::STORE_ITEM);

        $this->getEventManager()->trigger($event, $this);

        return $this;
    }


}
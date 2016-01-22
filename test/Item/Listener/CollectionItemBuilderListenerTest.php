<?php
use Verona\Item\ItemFactoryEvent;
use Verona\Item\ItemFactoryEvents;
use Verona\Item\ItemFactoryInterface;
use Verona\Item\Listener\CollectionItemBuilderListener;
use Verona\Item\Type\CollectionItem;
use Verona\Item\Type\FormItem;
use Verona\Store\StorageInterface;
use Verona\Timetable\TimetableManagerInterface;

/**
 * Created by PhpStorm.
 * User: Nathan
 * Date: 21/01/2016
 * Time: 08:38
 */
class CollectionItemBuilderListenerTest extends PHPUnit_Framework_TestCase
{


    public function testPrepare()
    {

        $expectedId = 'COL:EXAMPLEID';
        $expectedName = 'EXAMPLENAME';

        $subId = 'FRM:EXAMPLEID2';
        $subType = FormItem::class;
        $subItem = new FormItem();
        $subItem->setId($subId);

        $storage = $this->getMock(StorageInterface::class);
        $storage->expects($this->once())
            ->method('get')
            ->willReturn([
                CollectionItem::EXCHANGE_ID => $expectedId,
                CollectionItem::EXCHANGE_NAME => $expectedName,
                CollectionItemBuilderListener::ITEM_CONFIG_KEY => [
                    [
                        CollectionItemBuilderListener::SUB_ID => $subId,
                        CollectionItemBuilderListener::SUB_TYPE => $subType
                    ]
                ]
            ]);

        $timetableManager = $this->getMock(TimetableManagerInterface::class);
        $timetableManager->method('getPointInTime')->willReturn(new \DateTime());

        $itemFactory = $this->getMock(ItemFactoryInterface::class);
        $itemFactory->expects($this->once())
            ->method('getItem')
            ->with($this->equalTo($subItem))
            ->willReturn($subItem);

        $collectionItem = new CollectionItem();
        $collectionItem->setId($expectedId);
        $event = new ItemFactoryEvent();
        $event->setItem($collectionItem)
            ->setName(ItemFactoryEvents::PREPARE_ITEM);

        $listener = new CollectionItemBuilderListener($storage, $timetableManager, $itemFactory);
        $listener->prepareItem($event);

        $this->assertEquals([$subItem], $collectionItem->getAll());
        $this->assertEquals($expectedId, $collectionItem->getId());
        $this->assertEquals($expectedName, $collectionItem->getName());

    }
}

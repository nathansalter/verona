<?php

namespace Verona\Item;

final class ItemFactoryEvents
{

    /**
     * Build the actual class
     *
     * @var string
     */
    const PREPARE_ITEM = 'itemFactory.prepareItem';

    /**
     * Save the class
     *
     * @var string
     */
    const STORE_ITEM = 'itemFactory.storeItem';

}
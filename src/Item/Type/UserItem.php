<?php


namespace Verona\Item\Type;


use Verona\Item\AbstractItem;

class UserItem extends AbstractItem implements SimpleTypeInterface
{

    const ID_PREFIX = 'USR:';

    private $firstname;

    private $surname;

    /**
     * @var UserGroupItem
     */
    private $userGroup;

    /**
     * @var
     */
    private $permissions;

}
<?php


namespace Verona\Item\Type;


use Verona\Item\AbstractItem;
use Verona\Item\ItemInterface;

class UserGroupItem extends AbstractItem
{

    const EXCHANGE_NAME = 'name';

    const ID_PREFIX = 'GRP:';

    /**
     * @var string
     */
    private $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return UserGroupItem
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function toArray() : array
    {
        return array_merge([
            self::EXCHANGE_NAME => $this->getName()
        ], parent::toArray());
    }

    public function fromArray(array $data) : ItemInterface
    {
        parent::fromArray($data);

        if(isset($data[self::EXCHANGE_NAME])) {
            $this->setName($data[self::EXCHANGE_NAME]);
        }

        return $this;
    }


}
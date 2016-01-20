<?php


namespace Verona\Item;


abstract class AbstractItem implements ItemInterface
{

    /**
     * The string key to use when exchanging
     */
    const EXCHANGE_ID = 'id';

    /**
     * The default length of an ID, the longer this is, the smaller chance of a collision
     */
    const DEFAULT_ID_LENGTH = 32;

    /**
     * The alphabet to use for the randomly generated strings. Does not have vowels to ensure that words are not
     * accidentally created. The longer this is, the smaller chance of a collision
     */
    const ALPHABET = 'ABCDFGHJKLMNPQRSTVWXYZabcdfghjklmnpqrstvwxyz0123456789';

    /**
     * The Prefix for the Id to show what type of item it is (for easier reading in DB)
     */
    const ID_PREFIX = 'GEN:';

    /**
     * A Unique identifier
     *
     * @var string
     */
    private $id;

    /**
     * @param string $prefix
     * @param int $length
     * @return ItemInterface
     */
    protected function assignId(string $prefix = self::ID_PREFIX, int $length = self::DEFAULT_ID_LENGTH) : ItemInterface
    {
        $id = $prefix;

        for ($i = strlen($id); $i < $length; $i++) {
            $id .= substr(static::ALPHABET, mt_rand(0, strlen(static::ALPHABET)), 1);
        }

        $this->id = $id;
        return $this;
    }

    /**
     * Update the ID to the specified ID
     *
     * @param string $id
     * @return ItemInterface
     */
    public function setId(string $id) : ItemInterface
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Return the given id
     *
     * @return string
     */
    public function getId() : string
    {
        if ($this->id === null) {
            $this->assignId();
        }
        return $this->id;
    }

    /**
     * Convert the object into an array
     *
     * @return array
     */
    public function toArray() : array
    {
        return [
            self::EXCHANGE_ID => $this->getId()
        ];
    }

    /**
     * Replace the values in the object with the ones from the given array
     *
     * @param array $data
     * @return ItemInterface
     */
    public function fromArray(array $data) : ItemInterface
    {
        if (isset($data[self::EXCHANGE_ID])) {
            $this->setId($data[self::EXCHANGE_ID]);
        }

        return $this;
    }


}
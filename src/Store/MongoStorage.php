<?php


namespace Verona\Store;


class MongoStorage implements StorageInterface
{

    /**
     * @var \MongoDB
     */
    private $mongoDb;

    const DATA = 'data';

    const UPDATED = '_updated';

    const ID = '_id';

    /**
     * @return \MongoDB
     */
    public function getMongoDb()
    {
        if (!$this->mongoDb instanceof \MongoDB) {
            throw new \RuntimeException(sprintf('%s() Could not find a mongo connection', __METHOD__));
        }
        return $this->mongoDb;
    }

    /**
     * @param \MongoDB $mongoDb
     * @return MongoStorage
     */
    public function setMongoDb(\MongoDB $mongoDb)
    {
        $this->mongoDb = $mongoDb;
        return $this;
    }

    public function has(string $type, $id, \DateTime $at) : bool
    {
        $collection = $this->getMongoDb()->createCollection($type);
        $collection->setSlaveOkay();

        $result = $collection->find([
            self::ID => [
                self::ID => $id,
                self::UPDATED => [
                    '$lte' => new \MongoDate($at->getTimestamp())
                ]
            ]
        ])->count();

        return $result > 0;
    }

    /**
     * @param string $type
     * @param string $id
     * @param \DateTime $at
     * @return array
     */
    public function get(string $type, string $id, \DateTime $at) : array
    {

        $collection = $this->getMongoDb()->createCollection($type);
        $collection->setSlaveOkay();

        $result = $collection->find([
            self::ID => [
                self::ID => $id,
                self::UPDATED => [
                    '$lte' => new \MongoDate($at->getTimestamp())
                ]
            ]
        ])->sort(['_id._updated' => -1])
            ->limit(1);

        if ($result->count() == 0) {
            throw new \RuntimeException(sprintf('%s() should not be called for objects which do not exist', __METHOD__));
        }

        return $result->current()[self::DATA];

    }

    /**
     * @param string $type
     * @param string $id
     * @param array $data
     * @return StorageInterface
     */
    public function store(string $type, string $id, array $data) : StorageInterface
    {
        $collection = $this->getMongoDb()->createCollection($type);

        $collection->insert([
            self::ID => [
                self::ID => $id,
                self::UPDATED => new \MongoDate()
            ],
            self::DATA => $data
        ]);

        return $this;
    }


}
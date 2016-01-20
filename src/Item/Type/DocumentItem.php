<?php


namespace Verona\Item\Type;


use Verona\Item\AbstractItem;
use Verona\Item\ItemInterface;

class DocumentItem extends AbstractItem implements SimpleTypeInterface
{

    const EXCHANGE_NAME = 'name';

    const EXCHANGE_FILE_NAME = 'filename';

    const EXCHANGE_MIME_TYPE = 'mime';

    const EXCHANGE_FILE_SIZE = 'size';

    const ID_PREFIX = 'DOC:';

    /**
     * @var string The filename for this version of the file
     */
    private $filename;

    /**
     * @var string The User-given name of the file
     */
    private $name;

    /**
     * @var string the MIME type of the file
     */
    private $mimeType;

    /**
     * @var int The fileSize, in bytes
     */
    private $fileSize;

    /**
     * DocumentItem constructor.
     */
    public function __construct()
    {
        $this->assignId(static::ID_PREFIX);
    }

    /**
     * @return string
     */
    public function getFilename() : string
    {
        if (!$this->hasFilename()) {
            throw new \RuntimeException(sprintf('%s() does not have a filename available', __METHOD__));
        }
        return $this->filename;
    }

    /**
     * @return bool
     */
    public function hasFilename() : bool
    {
        return $this->filename !== null;
    }

    /**
     * @param string $filename
     * @return DocumentItem
     */
    public function setFilename($filename) : DocumentItem
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        if (!$this->hasName()) {
            throw new \RuntimeException(sprintf('%s() did not have a name available', __METHOD__));
        }
        return $this->name;
    }

    /**
     * @return bool
     */
    public function hasName() : bool
    {
        return $this->name !== null;
    }

    /**
     * @param string $name
     * @return DocumentItem
     */
    public function setName(string $name) : DocumentItem
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getMimeType() : string
    {
        if (!$this->hasMimeType()) {
            throw new \RuntimeException(sprintf('%s() did not have a mime type availalbe', __METHOD__));
        }
        return $this->mimeType;
    }

    /**
     * @return bool
     */
    public function hasMimeType() : bool
    {
        return $this->mimeType !== null;
    }

    /**
     * @param string $mimeType
     * @return DocumentItem
     */
    public function setMimeType($mimeType) : DocumentItem
    {
        $this->mimeType = $mimeType;
        return $this;
    }

    /**
     * @return int
     */
    public function getFileSize()
    {
        if (!$this->hasFileSize()) {
            throw new \RuntimeException(sprintf('%s() did not have a file size availalbe', __METHOD__));
        }
        return $this->fileSize;
    }

    /**
     * @return bool
     */
    public function hasFileSize() : bool
    {
        return $this->fileSize !== null;
    }

    /**
     * @param int $fileSize
     * @return DocumentItem
     */
    public function setFileSize(int $fileSize)
    {
        $this->fileSize = $fileSize;
        return $this;
    }


    /**
     * @return array
     */
    public function toArray() : array
    {
        return array_merge(array_filter([
            self::EXCHANGE_FILE_NAME => $this->hasFilename() ? $this->getFilename() : null,
            self::EXCHANGE_NAME => $this->hasName() ? $this->getName() : null,
            self::EXCHANGE_FILE_SIZE => $this->hasFileSize() ? $this->getFileSize() : null,
            self::EXCHANGE_MIME_TYPE => $this->hasMimeType() ? $this->getMimeType() : null
        ]), parent::toArray());
    }

    /**
     * @param array $data
     * @return ItemInterface
     */
    public function fromArray(array $data) : ItemInterface
    {
        parent::fromArray($data);

        if (isset($data[self::EXCHANGE_FILE_NAME])) {
            $this->setFilename($data[self::EXCHANGE_FILE_NAME]);
        }

        if (isset($data[self::EXCHANGE_NAME])) {
            $this->setName($data[self::EXCHANGE_NAME]);
        }

        if (isset($data[self::EXCHANGE_FILE_SIZE])) {
            $this->setFileSize($data[self::EXCHANGE_FILE_SIZE]);
        }

        if (isset($data[self::EXCHANGE_MIME_TYPE])) {
            $this->setMimeType($data[self::EXCHANGE_MIME_TYPE]);
        }

        return $this;
    }


}
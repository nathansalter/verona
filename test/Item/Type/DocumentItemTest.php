<?php
use Verona\Item\Type\DocumentItem;

/**
 * Created by PhpStorm.
 * User: Nathan
 * Date: 22/01/2016
 * Time: 12:52
 */
class DocumentItemTest extends PHPUnit_Framework_TestCase
{


    /**
     * @return DocumentItem
     */
    public function testGettersAndSetters()
    {

        $document = new DocumentItem();

        $expectedFilename = 'rawr.gif';
        $this->assertFalse($document->hasFilename());
        $this->assertInstanceOf(DocumentItem::class, $document->setFilename($expectedFilename));
        $this->assertTrue($document->hasFilename());
        $this->assertEquals($expectedFilename, $document->getFilename());

        $expectedMime = 'image/gif';
        $this->assertFalse($document->hasMimeType());
        $this->assertInstanceOf(DocumentItem::class, $document->setMimeType($expectedMime));
        $this->assertTrue($document->hasMimeType());
        $this->assertEquals($expectedMime, $document->getMimeType());

        $expectedName = 'this file is work';
        $this->assertFalse($document->hasName());
        $this->assertInstanceOf(DocumentItem::class, $document->setName($expectedName));
        $this->assertTrue($document->hasName());
        $this->assertEquals($expectedName, $document->getName());

        $expectedFileSize = 192382;
        $this->assertFalse($document->hasFileSize());
        $this->assertInstanceOf(DocumentItem::class, $document->setFileSize($expectedFileSize));
        $this->assertTrue($document->hasFileSize());
        $this->assertEquals($expectedFileSize, $document->getFileSize());

        return $document;

    }

    /**
     * @param DocumentItem $document
     * @depends testGettersAndSetters
     */
    public function testExchangeable(DocumentItem $document)
    {

        $conf = $document->toArray();

        $newDocument = new DocumentItem();
        $newDocument->fromArray($conf);

        $this->assertEquals($document, $newDocument);

        $newConf = $newDocument->toArray();

        $this->assertEquals($conf, $newConf);

    }


}

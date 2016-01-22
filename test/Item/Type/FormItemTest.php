<?php
use Verona\Item\Type\FormItem;

/**
 * Created by PhpStorm.
 * User: Nathan
 * Date: 22/01/2016
 * Time: 13:10
 */
class FormItemTest extends PHPUnit_Framework_TestCase
{


    /**
     * @return FormItem
     */
    public function testGettersAndSetters()
    {

        $form = new FormItem();

        $expectedName = 'A FORM';
        $this->assertFalse($form->hasName());
        $this->assertInstanceOf(FormItem::class, $form->setName($expectedName));
        $this->assertTrue($form->hasName());
        $this->assertEquals($expectedName, $form->getName());

        $expectedDefinitions = [
            'def a' => [
                'input?' => 'rawr'
            ],
            'i have no idea' => 'what I am doing'
        ];
        $this->assertInstanceOf(FormItem::class, $form->setDefinitions($expectedDefinitions));
        $this->assertEquals($expectedDefinitions, $form->getDefinitions());

        $expectedValues = [
            'def a' => 15,
            'i have no idea' => 123.23
        ];
        $this->assertInstanceOf(FormItem::class, $form->setValues($expectedValues));
        $this->assertEquals($expectedValues, $form->getValues());

        return $form;

    }

    /**
     * @param FormItem $form
     * @depends testGettersAndSetters
     */
    public function testExchangeable(FormItem $form)
    {

        $conf = $form->toArray();

        $newForm = new FormItem();
        $newForm->fromArray($conf);

        $this->assertEquals($form, $newForm);

        $newConf = $newForm->toArray();

        $this->assertEquals($conf, $newConf);


    }


}

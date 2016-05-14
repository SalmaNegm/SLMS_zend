<?php

class Application_Form_Category extends Zend_Form
{

    public function init()
    {
        $name = new Zend_Form_Element_Text('name');
        $name->setRequired();
        $name->setLabel('name');
        $name->setAttrib('class','form-control col-1g-2');

        $description = new Zend_Form_Element_Textarea('description');
        $description->setRequired();
        $description->setLabel('description');
        $description->setAttribs(array('class'=>'form-control col-1g-2','rows'=>'5'));

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('ADD');
        $submit->setAttrib('class', 'btn btn-primary col-sm-offset-3 col-sm-5');

        $this->addElements(array($name,$description,$submit));
    }

}


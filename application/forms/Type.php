<?php

class Application_Form_Type extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $name = new Zend_Form_Element_Text('name');
		$name->setRequired();
		$name->setLabel('Material Type');
		$name->setAttrib('class', 'form-control');
		$name->setAttrib ( 'placeholder', 'Add New Type' );

	 	$id = new Zend_Form_Element_Hidden('id');
	 	
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('class', 'btn btn-primary');
		$this->addElements(array($id,$name,$submit));
    }


}


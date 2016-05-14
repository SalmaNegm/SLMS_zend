<?php

class Application_Form_Comment extends Zend_Form
{

    public function init()
    {
        $content = new Zend_Form_Element_Text('content');
		$content->setRequired();
		// $content->setLabel('content');

	
		$content->setAttrib('class', 'form-control');
		$content->setAttrib ( 'placeholder', 'Add Comment' );


		// $publish_date = new Zend_Date();
		// $publish_date->setRequired();
		// $publish_date->setLabel('publish_date');
		// $publish_date->setAttrib('class', 'form-control');
		
	 	$id = new Zend_Form_Element_Hidden('material_id');
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('class', 'btn btn-primary');
		$this->addElements(array($id,$content,$submit));

	}

}





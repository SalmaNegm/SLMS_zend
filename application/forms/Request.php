<?php

class Application_Form_Request extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */

        $content = new Zend_Form_Element_Text('content');
		$content->setRequired();
		$content->setLabel('SendRequest');
		$content->addValidator(new Zend_Validate_Db_NoRecordExists(
	    array(
	        'table' => 'requests',
	        'field' => 'content'
	   		 )
		));
		$content->setAttrib('class', 'form-control');
		
	 	$id = new Zend_Form_Element_Hidden('id');

		$submit = new Zend_Form_Element_Submit('Submit');


		$this->addElements(array($id,$content,$submit));
    

    }


}


<?php

class Application_Form_Request extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */

        $content = new Zend_Form_Element_Textarea('content');
		$content->setRequired();
    	$content->setAttribs(array(
                'rows'        => '5',
                'class'       => 'txt_meta'
        ));

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

		$submit->setAttrib('class', 'btn btn-primary');


		$this->addElements(array($id,$content,$submit));
    

    }


}


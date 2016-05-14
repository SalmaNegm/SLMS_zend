<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */

    $name = new Zend_Form_Element_Text('name');
	$name->setRequired();
	$name->setLabel('Name');
	$name->addValidator(new Zend_Validate_EmailAddress)
	->addValidator(new Zend_Validate_Db_NoRecordExists(
    array(
        'table' => 'users',
        'field' => 'name'
    )
));
	// $username->setAttrib('class', 'form-control');
	
 	// $id = new Zend_Form_Element_Hidden('id');
	$password = new Zend_Form_Element_Password('password');
	$password->setLabel('password');
        // $password->setAttrib('class', 'form-control');

	$password->addValidator(new Zend_Validate_StringLength(array('min'=>5, 'max'=>8)));

	$submit = new Zend_Form_Element_Submit('submit');
        // $submit->setAttrib('class', 'btn btn-info');
	$this->addElements(array($name,$password,$submit));


    }
}


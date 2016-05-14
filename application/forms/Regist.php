<?php

class Application_Form_Regist extends Zend_Form
{

    public function init()
    {
        
    $username = new Zend_Form_Element_Text('name');
	$username->setRequired();
	$username->setLabel('User name');
	$username->addValidator(new Zend_Validate_Db_NoRecordExists(
    array(
        'table' => 'users',
        'field' => 'name'
    )
	));
	//Email
	$email = new Zend_Form_Element_Text('email');
	$email->setRequired();
	$email->setLabel('E-mail');
	$email->addValidator(new Zend_Validate_EmailAddress)
	->addValidator(new Zend_Validate_Db_NoRecordExists(
    array(
        'table' => 'users',
        'field' => 'email'
    )
	));
	// $username->setAttrib('class', 'form-control');

	//Upload image profile


	$image = new Zend_Form_Element_File('image');
	$image->setLabel('Upload an image:')
          ->setRequired()     
          ->setDestination(realpath(APPLICATION_PATH . '/../public/upload'));
          // ->setValueDisabled(True);
      // ->setMaxFileSize(10240000) // limits the filesize on the client side
      

	$image->addValidator('Count', false, 1);                // ensure only 1 file
	$image->addValidator('Size', false, 10240000);            // limit to 10 meg
	$image->addValidator('Extension', false, 'jpg,jpeg,png,gif');// only JPEG, PNG, and GIFs

	//Gender

	$type=array(
		"male"=>"male",
		"female"=>"female"
		);

	$gender=new Zend_Form_Element_Radio('gender');
	$gender->setLabel("Gender")
		   ->setMultiOptions($type);


	//Type of user(rgular/admin)
	
	// $role=array(
	// 	"user"=>"user",
	// 	"admin"=>"admin"
	// 	);

	// $type=new Zend_Form_Element_Radio('type');
	// $type->setLabel("type")
	// 	   ->setMultiOptions($role)
	// 	   ->setValue('user'); 

	//Signature
	$signature = new Zend_Form_Element_Text('signature');
	$signature->setRequired();
	$signature->setLabel('Signature');

 	$id = new Zend_Form_Element_Hidden('id');
 	// $rule = new Zend_Form_Element_Hidden('rule');
 	


 	//Password
	$password = new Zend_Form_Element_Password('password');
	$password->setLabel('password');
        // $password->setAttrib('class', 'form-control');

	$password->addValidator(new Zend_Validate_StringLength(array('min'=>5, 'max'=>8)));

	//Submit button

	$submit = new Zend_Form_Element_Submit('submit');
        // $submit->setAttrib('class', 'btn btn-info');

	//Add elements to form

	$this->addElements(array($id,$username,$email, $password,$gender,$image, $signature,$submit));


    }


}


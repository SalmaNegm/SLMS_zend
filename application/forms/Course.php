<?php

class Application_Form_Course extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $content = new Zend_Form_Element_Text('name');
        $content->setRequired();
        $content->setLabel('name');
        $content->setAttrib('class','form-control col-1g-5');

        $description = new Zend_Form_Element_Textarea('description');
        $description->setRequired();
        $description->setLabel('description');
        $description->setAttribs(array('class'=>'form-control','rows'=>'5'));

        $category_id = new Zend_Form_Element_Select('category_id');
        $category_id->setRequired();
        $category_id->setLabel('category');
        $category_id->setAttrib('class','form-control');
        $category_id->setRegisterInArrayValidator(false);
        $catModel=new Application_Model_DbTable_Category();
        $categories=$catModel->listCategories();
        foreach ($categories as $category) {
            $category_id->addMultiOption($category['id'],$category['name']);
        }

        $image = new Zend_Form_Element_File('image');
        $image->setRequired();
        $image->setLabel('image');
        $image->setDestination(realpath(APPLICATION_PATH . '/../public/upload/courses'));
        $image->addValidator('IsImage');
        $originalFilename = pathinfo($image->getFileName());
        $newFilename = 'course-' . uniqid() . '.' . $originalFilename['extension'];
        $image->addFilter('Rename', $newFilename);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('ADD');
        $submit->setAttrib('class', 'btn btn-primary col-sm-offset-3 col-sm-5');
		$this->addElements(array($content,$description,$image,$category_id,$submit));

    }


}


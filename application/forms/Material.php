<?php
class Application_Form_Material extends Zend_Form
{
    public function init()
    {
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setMethod('post');
        $courses = new Application_Model_Course();
        $selectCourse= new Zend_Form_Element_Select('course_id');
        $selectCourse->setAttrib('class', 'form-control');
        $selectCourse->addMultiOption(0, 'Please select course...');
        foreach ($courses->fetchAll() as $course) {
            $selectCourse->addMultiOption($course['id'], $course['name']);
        }
        $this->addElement($selectCourse);

        $course_types = new Application_Model_DbTable_Type();
        $selectType= new Zend_Form_Element_Select('type_id');
        $selectType->setAttrib('class', 'form-control');
        $selectType->addMultiOption(0, 'Please select material type...');
        foreach ($course_types->fetchAll() as $type) {
            $selectType->addMultiOption($type['id'], $type['name']);
        }
        $this->addElement($selectType);

        $description = new Zend_Form_Element_Textarea('description');
        $description->setAttribs(array('class'=>'form-control','rows'=>'5'));
        $description->setLabel('Description')
            ->setRequired(true)
            ->addValidator('NotEmpty');
        $this->addElement($description);

        $submit= new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('class', 'btn btn-primary col-sm-offset-3 col-sm-5');

        $file = new Zend_Form_Element_File('file');
        $file->setLabel('File to upload:')
            ->setRequired(true)
            ->setDestination(APPLICATION_PATH .'/../public/upload/material')
            ->addValidator('NotEmpty')
            ->addValidator('Count', false, 1)
            ->addValidator('Size', false, 10485760) //10MB = 10,485,760 bytes
            ->setMaxFileSize(3097152);
        $this->addElement($file);

        $is_download= new Zend_Form_Element_Checkbox('is_download', array(
        'label'=>'download',
        'uncheckedValue'=> '0', //can be removed, this is the default functionality
        'checkedValue' => '1'));
         //can be removed, this is the default functionality
        $this->addElement($is_download);
        $is_show= new Zend_Form_Element_Checkbox('is_show', array(
        'label'=>'show',
        'uncheckedValue'=> '0', //can be removed, this is the default functionality
        'checkedValue' => '1'));                                                                                           
        $this->addElement($is_show);

        $this->addElements(array($submit, $description ,$file,$is_download,$is_show));
    }

}
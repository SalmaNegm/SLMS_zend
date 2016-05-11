<?php
class Application_Form_Material extends Zend_Form
{
    public function init()
    {
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setMethod('post');
        $description = new Zend_Form_Element_Text('description');
        $submit= new Zend_Form_Element_Submit('submit');
        $description->setLabel('Description')
            ->setRequired(true)
            ->addValidator('NotEmpty');
        $this->addElement($description);
        $file = new Zend_Form_Element_File('file');
        $file->setLabel('File to upload:')
            ->setRequired(true)
            // ->setDestination(APPLICATION_PATH .'/../upload/material')
            ->setDestination('/var/www/html/site/public/upload/material')
            ->addValidator('NotEmpty')
            ->addValidator('Count', false, 1);
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
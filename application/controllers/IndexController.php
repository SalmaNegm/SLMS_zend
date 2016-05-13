<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
         $this->layout = $this->_helper->layout();
         $this->model = new Application_Model_Course();
         $this->model_cat= new Application_Model_DbTable_Category();
    }

    public function indexAction()
    {
         $this->layout->setLayout('client');
         $courses= $this->model-> last5Courses();
         $cats = $this->model_cat -> listCategories();
         $this->view->courses = $courses;
         $this->view -> cats = $cats;
         // var_dump($course);
         
    }


}


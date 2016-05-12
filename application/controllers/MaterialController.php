<?php

class MaterialController extends Zend_Controller_Action
{
    private $model;
    private $modelcomment = null;
    public function init()
    {
        /* Initialize action controller here */
        $this->model = new Application_Model_DbTable_Material();
        $this->modelcomment = new Application_Model_DbTable_Comment();
        $this->layout = $this->_helper->layout();
    }


    public function indexAction()
    {
        $this->view->material = $this->model->listMaterial();
    }
    public function downloadAction()
    {
        $id = $this->getRequest()->getParam('id');
        $material = $this->model->getMaterialById($id);
        $file_ex= explode(".",$material[0]['name']);
        header('Content-type: application/'.$file_ex[1]);
        header("Content-Disposition: attachment; filename='".$material[0]['name']."'"); 
        readfile('/var/www/html/SLMS_zend/public/upload/material/'.$material[0]['name']);
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

    }
    public function listAction()
    {
        $this->view->material = $this->model->listMaterial();
    }
    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->model-> deleteMaterial($id))
            $this->redirect('material/index');
    }
    public function editAction()
    {
        // $this->_helper->layout()->disableLayout(); 
        // $this->_helper->viewRenderer->setNoRender(true);
        $id = $this->getRequest()->getParam('id');
        $column=$this->getRequest()->getParam('col');
        $material= $this->model->getMaterialById($id);
        $download=$material[0][$column];
        if($download == 0)
        {
            $download = 1;
        }
        else{
            $download=0;
        }
        $this->model->editMaterial($id,$download,$column);   
            $this->redirect('material/list');
        }
    public function uploadAction()
    {
        $form = new Application_Form_Material();
        $form->setAction($this->view->url());
        $request = $this->getRequest();
        if (!$request->isPost()) 
        {
            $this->view->form = $form;
            return;
        }
        
        

        // try 
        // {
        //     $form->file->receive();
        //     //upload complete!
        //     //...what now?
        //     $file_name = $form->file->getFileName();
        //     $data = $form->getValues();
        //       $this->model->uploadMaterial($data);
              

        //     // var_dump($data);
        //      // if ($this->model->uploadMaterial($data))
        //      //     $this->redirect('material/index');
        //     // if($form->isValid($this->getRequest()->getParams()))
        //     // {
        //     //     $data = $form->getValues();        
        //     //     // if ($this->model->uploadMaterial($data))
        //     //     //  // $this->redirect('material/index');
        //     //         var_dump($data);
        //     // }
            
        // // var_dump($form->file->getFileInfo());
        // } catch (Exception $exception) {
        // //error uploading file
        // $this->view->form = $form;
        // }
        if($this->getRequest()->isPost()){
        if($form->isValid($this->getRequest()->getParams())){
            $form->file->receive();
        $data = $form->getValues();        
        if ($this->model->uploadMaterial($data))
        $this->redirect('material/index');
        
        
    }

    }
   
    $this->view->form = $form;
    
    }
    public function singleAction()
    {
        $this->layout->setlayout('client');
      $course_id=1;
      $material_type_id=3;
      $material_id=2;
      $this->view->material = $this->model->getMaterialByCourseMaterial($course_id,$material_type_id);
      $form = new Application_Form_Comment();
      if($this->getRequest()->isPost()){
         if($form->isValid($this->getRequest()->getParams())){
            $data = $form->getValues();
            if ($this->modelcomment->addComment($data,$material_id)){
                        // $this->redirect('comments/index');
            }
        }
    }

    $this->view->form = $form;
    $comments=$this->modelcomment->listCommentsByMaterial($material_id);

    $this->view->comment=$comments;

    }

public function viewAction()
{
        // action body
    $this->layout->setlayout('client');
    $material_id = $this->getRequest()->getParam('id');
    $material=$this->model->getMaterialById($material_id);
    $file=$material[0]['name'];
    var_dump($file);

        // var_dump($material);
    $this->_helper->layout->disableLayout();
    $path='/var/www/html/SLMS_zend/SLMS_zend/public/upload/material/'.$file;
        // var_dump($path);
        // die();
    $file_ex= explode(".",$material[0]['name']);
    $ex=$file_ex[1];
    $name=$file_ex[0];

    switch ($ex) {
        case 'jpg':
                # code...
            $this->view->material = $this->model->getMaterialById($material_id);
        break;
        case 'pdf':
            $this->view->layout()->disableLayout();
            // $this->_helper->viewRenderer->setNoRender(true);
            header('Content-type:application/pdf');
            header('Content-Disposition:inline;filname=filename.pdf');
            header('Cache-control:private,max-age=0,must-revalidate');
            header('progma:public');
            ini_set('zlib.output_compression','0');
            echo file_get_contents($path);
        break;
        case 'mp4':
            $this->redirect('material/video');
        break;    
        default:
                # code...
        break;
    }
    
}

public function videoAction()
{
        // action body
    $material_id=2;
    $material=$this->model->getMaterialById($material_id);
    $file=$material[0]['name'];
    $path='/var/www/html/SLMS_zend/SLMS_zend/public/upload/material/'.$file;
    $this->view->video=$path;
}
        
        
}


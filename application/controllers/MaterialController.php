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

        $material_id = $this->getRequest()->getParam('material_id');       
        $material = $this->model->getMaterialById($material_id);
        $material[0]['no_downloads'] += 1;
        // // echo $material[0]['no_downloads'] ;
        // // die();
        $no_downloads=$material[0]['no_downloads'];

        $this->model->updateMaterial($material_id,$no_downloads);
        $file_ex= explode(".",$material[0]['name']);
        header('Content-type: application/'.$file_ex[1]);
        header("Content-Disposition: attachment; filename='".$material[0]['name']."'"); 
        readfile(APPLICATION_PATH .'/../public/upload/material/'.$material[0]['name']);
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
        $material=$this->model->getMaterialById($id);
        $r=$this->model-> deleteMaterial($id);
            if($r)
            {
                unlink(APPLICATION_PATH.'/../public/upload/material/'.$material[0]['name']);                               
                $this->redirect('material/index');               
            }
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
      // $course_id=1;
      // $material_type_id=5;
      // $material_id=2;
        $material_id = $this->getRequest()->getParam('material_id');
        $this->view->material=$this->model->getMaterialById($material_id);
      // $this->view->material = $this->model->getMaterialByCourseMaterial($course_id,$material_type_id);
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
    $material_id = $this->getRequest()->getParam('material_id');
    $material=$this->model->getMaterialById($material_id);
    $file=$material[0]['name'];
    // var_dump($file);

        // var_dump($material);
    // $this->_helper->layout->disableLayout();
    $path='/var/www/html/SLMS_zend/public/upload/material/'.$file;
        // var_dump($path);
        // die();
    $file_ex= explode(".",$material[0]['name']);
    $ex=$file_ex[1];
    $this->view->ex=$ex;
   
    $name=$file_ex[0];

    switch ($ex) {
        case 'jpg':
        case 'jpeg':
        case 'png':
            $this->view->material = $this->model->getMaterialById($material_id);
        break;
        case 'pdf':
        case 'ppt':
            // $this->_helper->viewRenderer->setNoRender(true);
            header('Content-type:application/pdf');
            header('Content-Disposition:inline;filname=filename.pdf');
            header('Cache-control:private,max-age=0,must-revalidate');
            header('progma:public');
            ini_set('zlib.output_compression','0');
            echo file_get_contents($path);
             $this->view->layout()->disableLayout();
        break;
        case 'mp4':
        case 'mp3':
        case 'avi':
            $this->view->material = $this->model->getMaterialById($material_id);
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
    // $material_id=2;
    $this->layout->setlayout('client');
    $material_id = $this->getRequest()->getParam('material_id');
    $material=$this->model->getMaterialById($material_id);
    $file=$material[0]['name'];
    $path='/var/www/html/SLMS_zend/SLMS_zend/public/upload/material/'.$file;
    $this->view->video=$path;
     // $this->view->material=$material;
}
        
        
}


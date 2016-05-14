<?php

class MaterialController extends Zend_Controller_Action
{
    private $model;
    public function init()
    {
        /* Initialize action controller here */
        $this->model = new Application_Model_DbTable_Material();
    }
    #/public/material/
    public function indexAction()
    {
        $this->view->material = $this->model->listMaterial();
    }
    public function downloadAction()
    {
        $id = $this->getRequest()->getParam('material_id');
        $material = $this->model->getMaterialById($id);
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
    function listByCourseId($id)
    {
        return $this->fetchAll($this->select()->where('course_id=?',$id))->toArray();
    }
    public function uploadvedioAction(){
        $form = new Application_Form_Materialvedio ();
        $form->setAction($this->view->url());
        $request = $this->getRequest();
        if (!$request->isPost()) 
        {
            $this->view->form = $form;
            return;
        }
        if($this->getRequest()->isPost()){
        if($form->isValid($this->getRequest()->getParams())){
            // $form->file->receive();
        $data = $form->getValues();        
        if ($this->model->uploadMaterial($data))
        $this->redirect('material/index');      
        
    }

    }
   
    $this->view->form = $form;
    
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
        
        if($this->getRequest()->isPost())
        {
            if($form->isValid($this->getRequest()->getParams())){
                $form->file->receive();
                $data = $form->getValues();        
                if ($this->model->uploadMaterial($data))
                    $this->redirect('material/index');
                    // $this->redirect("https://www.youtube.com/watch?v=kEpOv49P6Yg");      
        
            }
        }   
        $this->view->form = $form;
    
    }
        
        
}

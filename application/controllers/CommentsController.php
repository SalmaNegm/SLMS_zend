<?php

class CommentsController extends Zend_Controller_Action
{

     private $model = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->model = new Application_Model_DbTable_Comment();
    }

    public function indexAction()
    {
        // action body
         $this->view->comments = $this->model->listComments();
    }

    public function addAction()
    {
        
		$form = new Application_Form_Comment();
        // $auth =Zend_Auth::getInstance()->getStorage()->read();
        // $user_id=$auth->id;
        // echo $user_id;
		if($this->getRequest()->isPost()){
			if($form->isValid($this->getRequest()->getParams())){
				$data = $form->getValues();
				if ($this->model->addComment($data)){
					$this->redirect('comments/index');
                }
			}

		}
		$this->view->form = $form;
    }

    public function deleteAction()
    {
        // action body
        $id = $this->getRequest()->getParam('id');
		if($this->model->deleteComment($id))
			$this->redirect('comments/index');
    }

    public function editAction()
    {
       $id = $this->getRequest()->getParam('id');
		$comment = $this->model->getCommentById($id);
		$form = new Application_Form_Comment();
		$form->populate($comment[0]);
		if($this->getRequest()->isPost()){
			if($form->isValid($this->getRequest()->getParams())){
				$data = $form->getValues();

				$this->model->editComment($id,$data);	
                $this->redirect('comments/index');

			}
		}
		$this->view->form = $form;
    }


}


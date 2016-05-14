<?php

class UsersController extends Zend_Controller_Action
{

    private $model = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->model = new Application_Model_DbTable_User();
        // $this->layout = $this->_helper->disableLayout();
       $authorization = Zend_Auth::getInstance();
       if (!$authorization->hasIdentity()) {
           $this->redirect('users/login');
       }

    }

    public function indexAction()
    {
        // action body
        $this->view->users = $this->model->listusers();
        // $data=Zend_Auth::getInstance()->getStorage()->read();
        // var_dump($data);

    }

     public function deleteAction() {
        $id = $this->getRequest()->getParam('id');
        if ($this->model->deleteUser($id)) {
            $this->redirect('users/index');
        }
    }

   

    function editAction() {
        $id = $this->getRequest()->getParam('id');
        $user = $this->model->getUserById($id);
        $form = new Application_Form_Regist();
        $form->populate($user[0]);
        //$values = $this->getRequest()->getParams();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getParams())) {
                $data = $form->getValues();

                $this->model->editUser($data, $id);
            }
        }
        //$form->removeElement('submit');
        $this->view->form = $form;
        $this->render('edit');
    }


    public function loginAction()

    {
        $this->_helper->layout->disableLayout();

       // $authorization= Zend_Auth::getInstance();
       //  if ($authorization ->hasIdentity()) {
       //      $this->redirect('users/index');
       //  }
        $form = new Application_Form_Login();
        //$values = $this->getRequest()->getParams();
        if ($this->getRequest()->isPost()) {
            ///// authenticate user /////
            $username = $this->getRequest()->getParam('name');
            $password = $this->getRequest()->getParam('password');
            // $id = $this->getRequest()->getParam('id');

            

             // get the default db adapter
            $db = Zend_Db_Table::getDefaultAdapter();
            $authAdapter = new Zend_Auth_Adapter_DbTable($db, 'users','name', 'password');
            //set the email and password
            $authAdapter->setIdentity($username);
            $authAdapter->setCredential(md5($password));
            $result = $authAdapter->authenticate();
            if ($result->isValid()) {
                $auth = Zend_Auth::getInstance();
                $storage = $auth->getStorage();
                $storage->write($authAdapter->getResultRowObject(array('id','type', 'name','is_banned')));
                // var_dump($storage->read()->id);
                $this->redirect('users/index');
            } else {
                $this->redirect('users/regist');
            }
        }
        //$form->removeElement('submit');
        $this->view->form = $form;
    }

    public function roleAction(){

        $this->view->users = $this->model->listusers();

    }
    

 public function registAction()
    {
        // $this->layout->setlayout('regist');
         $this->_helper->layout->disableLayout();
         // $this->_helper->viewRenderer->setNoRender(true);
         $authorization = Zend_Auth::getInstance();
        if ($authorization->hasIdentity()) {
            $this->redirect('home/index');
        }

        $form = new Application_Form_Regist();
        if($this->getRequest()->isPost()){
            if($form->isValid($this->getRequest()->getParams())){
                $data = $form->getValues();
                
              
                if (!$form->image->receive())
                 {
                    print "Upload error";
                }
               

           
                if ($this->model->addUser($data))
                    $this->redirect('users/index');
                }}
                 $this->view->form = $form;
            }
}









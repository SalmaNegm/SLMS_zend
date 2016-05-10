<?php

class UsersController extends Zend_Controller_Action
{
	private $model;
    public function init()
    {
        /* Initialize action controller here */
        $this->model = new Application_Model_DbTable_User();

    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
    {
       $authorization = Zend_Auth::getInstance();
        if ($authorization->hasIdentity()) {
            $this->redirect('home/index');
        }
        $form = new Application_Form_Login();
        //$values = $this->getRequest()->getParams();
        if ($this->getRequest()->isPost()) {
            ///// authenticate user /////
            $username = $this->getRequest()->getParam('username');
            $password = $this->getRequest()->getParam('password');
             // get the default db adapter
            $db = Zend_Db_Table::getDefaultAdapter();
            $authAdapter = new Zend_Auth_Adapter_DbTable($db, 'users', 'username', 'password');
            //set the email and password
            $authAdapter->setIdentity($username);
            $authAdapter->setCredential(md5($password));
            $result = $authAdapter->authenticate();
            if ($result->isValid()) {
                $auth = Zend_Auth::getInstance();
                $storage = $auth->getStorage();
                $storage->write($authAdapter->getResultRowObject(array('id', 'username')));
                // var_dump($storage->read()->id);
                $this->redirect('home/index');
            } else {
                $this->redirect('users/login');
            }
        }
        //$form->removeElement('submit');
        $this->view->form = $form;
     }

 }







<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{


	protected function _initSession(){
		Zend_Session::start();
		$session = new Zend_Session_Namespace( 'Zend_Auth' );
		$session->setExpirationSeconds( 1800 );
	}

	protected function _initPlaceholders()
	{



		$this->bootstrap('View');
		$view = $this->getResource('View');
		$view->doctype('XHTML1_STRICT');
		//Meta
		$view->headMeta()->appendName('keywords', 'framework, PHP')->appendHttpEquiv('Content-Type','text/html;charset=utf-8');

		// ('Content-Type', 'text/html;charset=utf-8');
		// Set the initial title and separator:
		$view->headTitle('SLMS')->setSeparator(' :: ');
		// Set the initial stylesheet:
		// $view->headLink()->prependStylesheet("http://localhost/Zend/SLMS_project/public/css/bootstrap.css");
		// $view->headLink()->prependStylesheet("http://localhost/Zend/SLMS_project/public/css/sb-admin.css"); //admin
  //   	$view->headLink()->prependStylesheet("http://localhost/Zend/SLMS_project/public/css/morris.css");//admin
  //   	$view->headLink()->prependStylesheet("http://localhost/Zend/SLMS_project/public/css/font-awesome.min.css");//admin


  //   	$view->headLink()->prependStylesheet("http://localhost/Zend/SLMS_project/public/css/font-awesome.css");//client
  //   	$view->headLink()->prependStylesheet("http://localhost/Zend/SLMS_project/public/css/templatemo_style.css");//client
  //   	$view->headLink()->prependStylesheet("http://localhost/Zend/SLMS_project/public/css/templatemo_misc.css");//client
  //   	$view->headLink()->prependStylesheet("http://localhost/Zend/SLMS_project/public/css/flexslider.css");//client
  //   	$view->headLink()->prependStylesheet("http://localhost/Zend/SLMS_project/public/css/testimonails-slider.css");//client
  //   	$view->headLink()->prependStylesheet("http://localhost/Zend/SLMS_project/public/css/font-awesome.min.css");//client

		// // Set the initial JS to load:
		// $view->headScript()->prependFile('http://localhost/Zend/SLMS_project/public/js/jquery.js');
		// $view->headScript()->prependFile('http://localhost/Zend/SLMS_project/public/js/bootstrap.js');



		// $view->headScript()->prependFile('http://localhost/Zend/SLMS_project/public/js/modernizr-2.6.1-respond-1.1.0.min.js');//client
		// $view->headScript()->prependFile('http://localhost/Zend/SLMS_project/public/js/jquery-1.11.0.min.js');//client
		// $view->headScript()->prependFile('http://localhost/Zend/SLMS_project/public/js/jquery.gmap3.min.js');//client
		// $view->headScript()->prependFile('http://localhost/Zend/SLMS_project/public/js/plugins.js');//client
		// $view->headScript()->prependFile('http://localhost/Zend/SLMS_project/public/js/main.js');//client



		// $view->headScript()->prependFile('http://localhost/Zend/SLMS_project/public/js/raphael.min.js');//admin
		// $view->headScript()->prependFile('http://localhost/Zend/SLMS_project/public/js/morris.min.js');//admin
		// $view->headScript()->prependFile('http://localhost/Zend/SLMS_project/public/js/morris-data.js');//admin

		$view->headLink()->prependStylesheet('http://localhost/SLMS_zend/public/css/bootstrap.min.css');
		// Set the initial JS to load:
		$view->headScript()->prependFile('http://localhost/SLMS_zend/public/js/bootstrap.min.js');
		$view->headScript()->prependFile('http://localhost/SLMS_zend/public/js/bootstrap.js');


		$view->headScript()->prependFile('http://localhost/SLMS_zend/public/js/jquery-1.12.0.min.js');
		$view->headScript()->prependFile('/SLMS_zend/public/js/jquery-1.11.3.min.js');
		$view->headScript()->prependFile('/SLMS_zend/public/js/jquery-1.11.0.min.js');
		// $view->headScript()->prependFile('/SLMS_zend/public/js/slider.js');
   	
	 }

}


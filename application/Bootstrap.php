<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initRequest() {
            $this->bootstrap('FrontController');
            $front = $this->getResource('FrontController');
            $request = new Zend_Controller_Request_Http();
            $front->setRequest($request);
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
		

    	$view->headLink()->prependStylesheet($view->baseUrl()."/css/font-awesome.css");//client
    	$view->headLink()->prependStylesheet($view->baseUrl()."/css/templatemo_style.css");//client
    	$view->headLink()->prependStylesheet($view->baseUrl()."/css/templatemo_misc.css");//client
    	$view->headLink()->prependStylesheet($view->baseUrl()."/css/flexslider.css");//client
    	$view->headLink()->prependStylesheet($view->baseUrl()."/css/testimonails-slider.css");//client
    	$view->headLink()->prependStylesheet($view->baseUrl()."/css/font-awesome.min.css");//client



    	$view->headLink()->prependStylesheet($view->baseUrl()."/css/bootstrap.css");
		$view->headLink()->prependStylesheet($view->baseUrl()."/css/sb-admin.css"); //admin
    	$view->headLink()->prependStylesheet($view->baseUrl()."/css/morris.css");//admin
    	$view->headLink()->prependStylesheet($view->baseUrl()."/css/font-awesome.min.css");//admin



		// Set the initial JS to load:
		$view->headScript()->prependFile($view->baseUrl().'/js/jquery.js');
		$view->headScript()->prependFile($view->baseUrl().'/js/bootstrap.js');



		$view->headScript()->prependFile($view->baseUrl().'/js/modernizr-2.6.1-respond-1.1.0.min.js');//client
		$view->headScript()->prependFile($view->baseUrl().'/js/jquery-1.11.0.min.js');//client
		$view->headScript()->prependFile($view->baseUrl().'/js/jquery.gmap3.min.js');//client
		$view->headScript()->prependFile($view->baseUrl().'/js/plugins.js');//client
		$view->headScript()->prependFile($view->baseUrl().'/js/main.js');//client



		$view->headScript()->prependFile($view->baseUrl().'/js/raphael.min.js');//admin
		$view->headScript()->prependFile($view->baseUrl().'/js/morris.min.js');//admin
		$view->headScript()->prependFile($view->baseUrl().'/js/morris-data.js');//admin

		$view->headLink()->prependStylesheet($view->baseUrl().'/css/bootstrap.min.css');
		// Set the initial JS to load:
		$view->headScript()->prependFile($view->baseUrl().'/js/bootstrap.min.js');
		$view->headScript()->prependFile($view->baseUrl().'/js/bootstrap.js');


		$view->headScript()->prependFile($view->baseUrl().'/js/jquery-1.12.0.min.js');
		$view->headScript()->prependFile($view->baseUrl().'/js/jquery-1.11.3.min.js');
		$view->headScript()->prependFile($view->baseUrl().'/js/jquery-1.11.0.min.js');
		// $view->headScript()->prependFile($view->baseUrl().'/js/slider.js');
   	
	 }

}


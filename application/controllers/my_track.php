<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'/libraries/REST_Controller.php');

//class My_track extends CI_Controller{  
class My_track extends REST_Controller{     
    function __construct() {  
        parent::__construct();  
//        $this->load->helper('url');
    }  
	
    function cors_headers() //Cross-origin resource sharing
    {
	header('Access-Control-Allow-Origin: *');
//	header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Max-Age: 1000');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    }	
	function track()
	{	
		header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Max-Age: 1000');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		/*
		$this->input->post('s_id');
		$this->input->post('j_name');
		$this->input->post('j_url');
		$this->input->post('j_cname');
		$this->input->post('j_address');
		$this->input->post('j_date');
		*/
		
		$data = array(
		   's_id' => $this->input->post('s_id') ,
		   'j_name' => $this->input->post('j_name') ,
		   'j_url' => $this->input->post('j_url'),
		   'j_cname' => $this->input->post('j_cname') ,
		   'j_address' => $this->input->post('j_address') ,
		   'j_date' => $this->input->post('j_date')
		);
		
		//print_r($data);
		$this->load->model('track_model');
		$this->track_model->go_track($data);
	}
	function tracked_options()
	{
	        $this->cors_headers();
        	$this->response($_SERVER['HTTP_ORIGIN']);
	}
	function tracked_get()
	{
		$this->tracked_post();
	}
	function tracked_post()
	{
		$this->cors_headers();
                $this->load->model('track_model');
                $this->response($this->track_model->select_track($this->input->get_post('s_id')));
	}	
	function delTrack_post()
	{
		$this->cors_headers();
                $this->load->model('track_model');
                $this->response($this->track_model->del_track($this->input->get_post('t_id')));

	}

	function tracked()
	{	
		header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Max-Age: 1000');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		$this->load->model('track_model');
		$this->track_model->select_track();
	}
}  
?> 
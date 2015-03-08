<?php
class Home extends CI_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('reviews_model');
    }
	
	public function index()
	{
		$data['preporuke'] = $this->reviews_model->recommend_popular();
		
		$this->load->view('header');
		$this->load->view('home_view', $data);
		$this->load->view('footer');
	}
}
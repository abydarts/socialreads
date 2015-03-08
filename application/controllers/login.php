<?php
class Login extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('login_model');
	}
	
    public function index($msg = NULL){
		if($this->session->userdata('validated')) redirect('home');
		
		$this->form_validation->set_rules('username', 'username', 'required|min_length[5]|max_length[50]');
		$this->form_validation->set_rules('password', 'password', 'required|min_length[5]|max_length[50]');
		
		if ($this->form_validation->run() == TRUE)
		
		$data['msg'] = $msg;
		$data['title'] = 'Login';
		$this->load->view('login_view', $data);
    }

	public function process(){
		$result = $this->login_model->validate();

		if(!$result) {
			redirect('login');
		}
		else {
			redirect('home');
		}
	}
	
	public function register() {
		$this->form_validation->set_rules('username', 'username', 'required|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('password', 'password', 'required|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('email', 'email', 'required|valid_email|min_length[5]|max_length[50]');
		
		if ($this->form_validation->run() == FALSE || !$this->login_model->unique_username($this->input->post('username'))) {
			redirect('login');
		}
		
		$this->login_model->register();
		redirect('login');
	}
	
	public function do_logout(){
		$this->session->unset_userdata('userid');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('validated');
		$this->session->unset_userdata('last_page');
		$this->session->unset_userdata('is_admin');
		$this->session->sess_destroy();
		redirect('login');
	}
}
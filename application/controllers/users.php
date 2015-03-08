<?php
class Users extends CI_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('users_model');
		$this->load->model('reviews_model');
    }
	
	public function index() {		
		$config = array(
			'base_url'		=> base_url().'/users/',
			'uri_segment'	=> 2,
			'offset'		=> $this->uri->segment(2),
			'total_rows'	=> $this->users_model->get_users_number(),
			'per_page'		=> 20,
			'num_links'		=> 4,
			'first_link'	=> 'Prva',
			'last_link'		=> 'Posljednja'
		);
		
		$data['users'] = $this->users_model->get_users($config);
		
		$this->pagination->initialize($config);
		
		$this->load->view('header');
		$this->load->view('users_view', $data);
		$this->load->view('footer');
	}
	
	public function recommendations(){
		$userid = $this->session->userdata('userid');
		$top = 12;
		
		$data['users'] = $this->reviews_model->recommend_users($userid, $top);
						
		$this->load->view('header');
		$this->load->view('useri_preporuke_view', $data);
		$this->load->view('footer');
	}
	
	public function write_message() {
		$data['friends'] = $this->users_model->get_friends_list($this->session->userdata('userid'));
		if($this->input->post('user')) $data['user'] = $this->input->post('user'); else $data['user'] = 0;
		
		$this->load->view('header');
		$this->load->view('pisanje_poruke_view', $data);
		$this->load->view('footer');
	}
	
	public function send_message() {
		$data = array(
			'Subject' => $this->input->post('Subject'),
			'Content' => $this->input->post('Content'),
			'User1' => $this->session->userdata('userid'),
			'User2' => $this->input->post('User-ID'),
			'DateTime' => date('Y-m-d H-i-s'),
			'Viewed' => 0
		);
		
		$this->users_model->send_message($data);
		
		$this->outbox();
	}
	
	public function view_message() {
		$id = $this->uri->segment(3);
	
		if(!$this->users_model->is_owner($this->session->userdata('userid'), $id)) redirect('home');
		
		$data['poruka'] = $this->users_model->get_message($id);
				
		$this->load->view('header');
		$this->load->view('poruka_view', $data);
		$this->load->view('footer');
	}
	
	public function inbox() {
		$data['poruke'] = $this->users_model->get_messages($this->session->userdata('userid'), true);
		
		$this->load->view('header');
		$this->load->view('in_poruke_view', $data);
		$this->load->view('footer');
	}
	
	public function outbox() {
		$data['poruke'] = $this->users_model->get_messages($this->session->userdata('userid'), false);
		
		$this->load->view('header');
		$this->load->view('poruke_view', $data);
		$this->load->view('footer');
	}
	
	public function friends() {
		$config = array(
			'base_url'		=> base_url().'/friends/',
			'uri_segment'	=> 2,
			'offset'		=> $this->uri->segment(2),
			'total_rows'	=> $this->users_model->get_friends_number(),
			'per_page'		=> 20,
			'num_links'		=> 4,
			'first_link'	=> 'Prva',
			'last_link'		=> 'Posljednja'
		);
		
		$data['users'] = $this->users_model->get_friends($config);
		
		$this->pagination->initialize($config);
		
		$this->load->view('header');
		$this->load->view('friends_view', $data);
		$this->load->view('footer');
	}
	
	public function requests() {
		$data['users'] = $this->users_model->get_requests();
		
		$this->load->view('header');
		$this->load->view('requests_view', $data);
		$this->load->view('footer');
	}
	
	public function friend_request() {
		$data = array(
			'User1' => $this->input->post('User1'),
			'User2' => $this->input->post('User2'),
			'DateTime' => $this->input->post('DateTime'),
			'Confirmed' => $this->input->post('Confirmed'),
			'DateTime' =>  date('Y-m-d H-i-s')
		);
		$this->users_model->request($data);
	}
	
	public function confirm_friendship() {
		$data = array(
			'User1' => $this->input->post('User1'),
			'User2' => $this->input->post('User2'),
			'DateTime' => $this->input->post('DateTime'),
			'Confirmed' => $this->input->post('Confirmed'),
			'DateTime' =>  date('Y-m-d H-i-s')
		);
		$this->users_model->confirm($data);
	}
	
	public function profile() {
		if(!$this->is_friend($this->uri->segment(3))) redirect('home');
		$data['user'] = $this->users_model->get_profile($this->uri->segment(3));
		
		$data['friends'] = $this->users_model->get_friends_list($this->uri->segment(3));
		
		$this->load->view('header');
		$this->load->view('profile_view', $data);
		$this->load->view('footer');
	}
	
	public function unfriend() {
		$this->users_model->unfriend($this->input->post('User1'), $this->input->post('User2'));
	}
	
	public function is_friend($id) {
		return($this->users_model->is_friend($id));
	}
}
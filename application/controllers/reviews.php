<?php
class Reviews extends CI_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('reviews_model');
		$this->load->model('users_model');
    }
	
	public function index() {		
		$config = array(
			'base_url'		=> base_url().'/reviews/',
			'uri_segment'	=> 2,
			'offset'		=> $this->uri->segment(2),
			'total_rows'	=> $this->reviews_model->get_reviews_number(),
			'per_page'		=> 5,
			'num_links'		=> 4,
			'first_link'	=> 'Prva',
			'last_link'		=> 'Posljednja'
		);
		
		$data['reviews'] = $this->reviews_model->get_reviews($config);
		
		$this->pagination->initialize($config);
		
		$this->load->view('header');
		$this->load->view('reviews_view', $data);
		$this->load->view('footer');
	}
	
	public function my_reviews() {
		$config = array(
			'base_url'		=> base_url().'/reviews/my_reviews',
			'uri_segment'	=> 2,
			'offset'		=> $this->uri->segment(2),
			'total_rows'	=> $this->reviews_model->get_reviews_number($this->session->userdata('userid')),
			'per_page'		=> 5,
			'num_links'		=> 4,
			'first_link'	=> 'Prva',
			'last_link'		=> 'Posljednja'
		);
		
		$data['reviews'] = $this->reviews_model->get_reviews($config, $this->session->userdata('userid'));
		
		$this->pagination->initialize($config);
		
		$this->load->view('header');
		$this->load->view('reviews_view', $data);
		$this->load->view('footer');
	}
	
	public function friends_reviews() {
		$config = array(
			'base_url'		=> base_url().'/reviews/friends_reviews',
			'uri_segment'	=> 2,
			'offset'		=> $this->uri->segment(2),
			'total_rows'	=> $this->reviews_model->get_friends_reviews_number($this->session->userdata('userid')),
			'per_page'		=> 5,
			'num_links'		=> 4,
			'first_link'	=> 'Prva',
			'last_link'		=> 'Posljednja'
		);
		
		$data['reviews'] = $this->reviews_model->get_friends_reviews($config, $this->session->userdata('userid'));
		
		$this->pagination->initialize($config);
		
		$this->load->view('header');
		$this->load->view('reviews_view', $data);
		$this->load->view('footer');
	}
	
	public function user_reviews() {
		$config = array(
			'base_url'		=> base_url().'/reviews/user_reviews',
			'uri_segment'	=> 4,
			'offset'		=> $this->uri->segment(4),
			'total_rows'	=> $this->reviews_model->user_reviews_number($this->uri->segment(3)),
			'per_page'		=> 5,
			'num_links'		=> 4,
			'first_link'	=> 'Prva',
			'last_link'		=> 'Posljednja'
		);
		$data['reviews'] = $this->reviews_model->user_reviews($config, $this->uri->segment(3));
		
		$this->pagination->initialize($config);
		
		$this->load->view('header');
		$this->load->view('reviews_view', $data);
		$this->load->view('footer');
	}
	
	public function book_reviews()
	{
		$config = array(
			'base_url'		=> base_url().'/reviews/book_reviews',
			'uri_segment'	=> 4,
			'offset'		=> $this->uri->segment(4),
			'total_rows'	=> $this->reviews_model->get_book_reviews_number($this->uri->segment(3)),
			'per_page'		=> 5,
			'num_links'		=> 4,
			'first_link'	=> 'Prva',
			'last_link'		=> 'Posljednja'
		);
		$data['reviews'] = $this->reviews_model->get_book_reviews($config, $this->uri->segment(3));
		
		$this->pagination->initialize($config);
		
		$this->load->view('header');
		$this->load->view('reviews_view', $data);
		$this->load->view('footer');
	}
	
	public function review()
	{
		$data['recenzija'] = $this->reviews_model->get_review($this->uri->segment(3), $this->uri->segment(4));
		$data['recenzija']['prijatelj'] = $this->users_model->is_friend($data['recenzija']['UserID']);
		if($this->session->userdata('userid') == $this->uri->segment(4))
			$data['recenzija']['ja'] = true; else $data['recenzija']['ja'] = false;
		
		$data['komentari'] = $this->reviews_model->get_comments($this->uri->segment(3), $this->uri->segment(4));
		
		$this->load->view('header');
		$this->load->view('recenzija_view', $data);
		$this->load->view('footer');
	}
	
	public function postavi_komentar()
	{
		$data = array(
			'Content'		=> $this->input->post('review'),
			'User-ID'		=> $this->input->post('userid'),
			'ISBN'			=> $this->input->post('isbn'),
			'Commenter-ID'	=> $this->session->userdata('userid'),
			'DateTime' 		=> date('Y-m-d H-i-s')
		);
		$this->reviews_model->set_komentar($data);

		redirect(base_url().'reviews/review/'.$data['ISBN'].'/'.$data['User-ID']);
	}
	
	public function print_scores()
	{
		$data = compare_algorithms();
		
		echo 'average difference 1: '.$data['averageDifference1'].' root mean square 1: '.$data['rootMeanSquare1'];
		echo '\naverage difference 1: '.$data['averageDifference2'].' root mean square 2: '.$data['rootMeanSquare2'];
		echo 'f-score 1: '.$data['fscore1'].' f-score2: '.$data['fscore1'];
	}
	
	public function import_reviews_to_deviation()
	{
		$this->reviews_model->partial_update_deviation_table();
	}
}
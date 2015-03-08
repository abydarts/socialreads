<?php
class Books extends CI_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('books_model');
		$this->load->model('reviews_model');
    }
	
	public function index() {		
		$config = array(
			'base_url'		=> base_url().'/books/',
			'uri_segment'	=> 2,
			'offset'		=> $this->uri->segment(2),
			'total_rows'	=> $this->books_model->get_books_number(),
			'per_page'		=> 20,
			'num_links'		=> 4,
			'first_link'	=> 'Prva',
			'last_link'		=> 'Posljednja'
		);
		
		$data['books'] = $this->books_model->get_books($config);
		
		$this->pagination->initialize($config);
		
		$this->load->view('header');
		$this->load->view('books_view', $data);
		$this->load->view('footer');
	}
	
	public function recenziranje() {
		$data['knjiga'] = $this->books_model->get_book_info($this->input->post('isbn'));
	
		$this->load->view('header');
		$this->load->view('recenziranje_view', $data);
		$this->load->view('footer');
	}
	
	public function postavi_recenziju() {
		$data = array(
			'User-ID'		=> $this->session->userdata('userid'),
			'ISBN'			=> $this->input->post('isbn'),
			'Book-Rating'	=> $this->input->post('radiobutton'),
			'Review' 		=> $this->input->post('review'),
			'DateTime' 		=> date('Y-m-d H-i-s')
		);
		$this->reviews_model->set_recenzija($data);
		
		redirect(base_url().'reviews/review/'.$data['ISBN'].'/'.$data['User-ID']);
	}
	
	public function book($isbn) {
		$data['knjiga'] = $this->books_model->get_book_info($this->uri->segment(3));
		
		$data['preporuke'] = $this->reviews_model->non_personalized_recommendation($isbn);
		
		$data['prosjek'] =  $this->reviews_model->predict_single($this->session->userdata('userid'), $isbn);
		
		$this->load->view('header');
		$this->load->view('book_view', $data);
		$this->load->view('np_preporuke_view', $data);
		$this->load->view('footer');
	}

	public function search() {
		$search = $this->input->post('search');
		
		if($search == '' || strlen($search) <= 2)
			$this->index();
		else
		{
			$data['books'] = $this->books_model->search_books($this->input->post('search'));
			
			$this->load->view('header');
			$this->load->view('books_view', $data);
			$this->load->view('footer');
		}
	}
	
	public function recommendations() {
		$userid = $this->session->userdata('userid');
		$top = 12;
		
		$data['books'] = $this->reviews_model->get_top_books($userid, $top);
						
		$this->load->view('header');
		$this->load->view('p_preporuke_view', $data);
		$this->load->view('footer');
	}
}
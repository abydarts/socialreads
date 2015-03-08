<?php
class Books_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
	
	public function get_books($config) {
		$this->db->from('bx-books');	
		$this->db->where('ISBN not in (SELECT `ISBN` from `bx-book-ratings` where `User-ID` = '.$this->session->userdata('userid').')');
		$this->db->order_by('DateTime', 'desc');
		$this->db->limit($config['per_page'], $config['offset']);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function search_books($search = null) {
		$this->db->from('bx-books');
		$this->db->where('`Book-Title` LIKE \'%'.$search.'%\' OR `Book-Author` LIKE \'%'.$search.'%\'');
		$this->db->order_by('DateTime', 'desc');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_book_info($ISBN) {
		$this->db->from('bx-books');
		$this->db->where('ISBN', $ISBN);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function get_books_number() {
		$this->db->from('bx-books');
		$this->db->where('ISBN not in (SELECT `ISBN` from `bx-book-ratings` where `User-ID` = '.$this->session->userdata('userid').')');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function get_recommendations($config) {
		$this->db->from('bx-books');		
		$this->db->order_by('DateTime', 'desc');
		$this->db->limit($config['per_page'], $config['offset']);
		$query = $this->db->get();
		return $query->result_array();
	}
}
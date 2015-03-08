<?php
class Users_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
	
	public function get_users($config) {
		$this->db->from('bx-users');
		$this->db->where('`User-ID` NOT IN (SELECT `User2` FROM `friendship` where `User1` = '.$this->session->userdata('userid').')');
		$this->db->where('`User-ID` != '.$this->session->userdata('userid'));
		$this->db->order_by('DateTime', 'desc');
		$this->db->limit($config['per_page'], $config['offset']);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_users_number() {
		$this->db->from('bx-users');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function get_friends($config) {
		$this->db->from('bx-users, friendship');
		$this->db->where('`bx-users`.`User-ID` = `friendship`.`User2`');
		$this->db->where('friendship.User1', $this->session->userdata('userid'));
		$this->db->where('friendship.Confirmed', 1);
		$this->db->order_by('friendship.DateTime', 'desc');
		$this->db->limit($config['per_page'], $config['offset']);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_friends_list($userid) {
		$this->db->select('Username, User-ID, Avatar');
		$this->db->from('bx-users, friendship');
		$this->db->where('`bx-users`.`User-ID` = `friendship`.`User2`');
		$this->db->where('friendship.User1', $userid);
		$this->db->order_by('friendship.DateTime', 'desc');
		$this->db->where('friendship.Confirmed', 1);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_friends_number() {
		$this->db->from('bx-users, friendship');
		$this->db->where('`bx-users`.`User-ID` = `friendship`.`User2`');
		$this->db->where('friendship.User2', $this->session->userdata('userid'));
		$this->db->where('friendship.Confirmed', 1);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function request($data) {
		$this->db->insert('friendship', $data);
	}
	
	public function confirm($data) {
		$this->db->insert('friendship', $data);
		
		$data2 = array( 'Confirmed' => $data['Confirmed']);
		
		$this->db->where('User2', $data['User1']);
		$this->db->where('User1', $data['User2']);
		$this->db->update('friendship', $data2);
	}
	
	public function get_requests() {
		$this->db->from('bx-users, friendship');
		$this->db->where('`bx-users`.`User-ID` = `friendship`.`User1`');
		$this->db->where('friendship.User2', $this->session->userdata('userid'));
		$this->db->where('friendship.Confirmed', 0);
		$this->db->order_by('friendship.DateTime', 'desc');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function is_friend($id) {
		$this->db->from('friendship');
		$this->db->where('User1', $this->session->userdata('userid'));
		$this->db->where('User2', $id);
		$query = $this->db->get();
		if($query->num_rows()) return true;
		return false;
	}
	
	public function send_message($data) {
		$this->db->insert('messages', $data);
	}
	
	public function is_owner($userid, $id) {
		$this->db->from('messages');
		$this->db->where('ID', $id);
		$this->db->where('User1 = '.$userid.' OR User2 = '.$userid);
		$query = $this->db->get();
		if(!$query->num_rows()) return false;
		return true;
	}
	
	public function get_message($id) {
		$this->db->select('`bx-users`.`User-ID` `User-ID`, `bx-users`.`Username` `Username`, ID, Avatar, Subject, Content, Viewed, messages.DateTime DateTime');
		$this->db->from('messages, bx-users');
		$this->db->where('`messages`.`User1` = `bx-users`.`User-ID`');
		$this->db->where('ID', $id);
		$query = $this->db->get();
		
		$this->db->where('ID', $id);
		$this->db->update('messages', array('Viewed' => 1));
		
		return $query->row_array();
	}
	
	public function get_messages($id, $in = true) {
		$this->db->select('`bx-users`.`User-ID` `User-ID`, `bx-users`.`Username` `Username`, ID, Avatar, Subject, Viewed, messages.DateTime DateTime');
		$this->db->from('messages, bx-users');
		if($in)
		{
			$this->db->where('`messages`.`User1` = `bx-users`.`User-ID`');
			$this->db->where('User2', $id);
		}
		else
		{
			$this->db->where('`messages`.`User2` = `bx-users`.`User-ID`');
			$this->db->where('User1', $id);
		}
		$this->db->order_by('messages.DateTime', 'desc');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_profile($userid) {
		$this->db->from('bx-users');
		$this->db->where('`bx-users`.`User-ID`', $userid);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function unfriend($userid1, $userid2) {
		$this->db->delete('friendship', array('User2' => $userid1, 'User2' => $userid2));
		$this->db->delete('friendship', array('User1' => $userid2, 'User2' => $userid1));
	}
}
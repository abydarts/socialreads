<?php
class Reviews_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }
	
	public function set_recenzija($data) {
		$this->db->insert('bx-book-ratings', $data);
		
		$this->db->where('ISBN', $data['ISBN']);
		$this->db->set('Reviews_Number', 'Reviews_Number+1', FALSE);
		$this->db->update('bx-books');
		
		$this->db->where('ISBN', $data['ISBN']);
		$this->db->set('Ratings_Sum', 'Ratings_Sum+'.$data['Book-Rating'], FALSE);
		$this->db->update('bx-books');
		
		//azuriranje tabele devijacija, poziv metode
		$this->update_deviation_table($data['ISBN'], $this->session->userdata('userid'));
		
		$this->update_pearson($this->session->userdata('userid'), $data['ISBN']);
	}
	
	public function set_komentar($data) {
		$this->db->insert('comments', $data);
	}
	
	public function update_deviation_table($ISBN, $userid) {
		//upit na bazu kojim se pronalaze svi mogući korisnikovi parovi ocjena za unesenu ocjenu
		$this->db->distinct();
		$this->db->select('r1.ISBN AS ISBN, r2.`Book-Rating` - r1.`Book-Rating` AS difference');
		$this->db->from('bx-book-ratings AS r1, bx-book-ratings AS r2');
		//$this->db->from('temp AS r1, temp AS r2');
		$this->db->where('r1.User-ID', $userid);
		$this->db->where('r2.User-ID', $userid);
		$this->db->where('r2.ISBN', $ISBN);
		$this->db->where('r1.ISBN != r2.ISBN');
		$this->db->where('r1.Book-Rating != 0');
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			//za svaki od parova vrsi se azuriranje tabele devijacija
			foreach($query->result() as $pair)
			{
				$ISBN2 = $pair->ISBN;
				$difference = $pair->difference;
				
				//provjera da li par vec postoji u tabeli devijacija
				$this->db->select('ISBN1');
				$this->db->from('deviation');
				$this->db->where('ISBN1', $ISBN);
				$this->db->where('ISBN2', $ISBN2);
				$query2 = $this->db->get();
				
				//ako par postoji azuriramo dva sloga
				if($query2->num_rows() > 0)
				{
					$this->db->where('ISBN1', $ISBN);
					$this->db->where('ISBN2', $ISBN2);
					$this->db->set('count', 'count+1', FALSE);
					$this->db->set('sum', 'sum+'.$difference, FALSE);
					$this->db->update('deviation');
										
					//unosimo samo za razlicite ISBN-ove
					if($ISBN != $ISBN2)
					{			
						$this->db->where('ISBN1', $ISBN2);
						$this->db->where('ISBN2', $ISBN);
						$this->db->set('count', 'count+1', FALSE);
						$this->db->set('sum', 'sum-'.$difference, FALSE);
						$this->db->update('deviation');
					}
				}
					
				//u suprotnom kreiramo 2 nova sloga u tabeli devijacija
				else
				{
					$data = array(
						'ISBN1' => $ISBN,
						'ISBN2' => $ISBN2,
						'count' => 1,
						'sum' => $difference
					);
					$this->db->insert('deviation', $data);
					
					//azuriramo samo ako su ISBN-ovi knjiga razliciti
					if($ISBN != $ISBN2) {
					
						$data2 = array(
							'ISBN1' => $ISBN2,
							'ISBN2' => $ISBN,
							'count' => 1,
							'sum' => -$difference
						);
						$this->db->insert('deviation', $data2);
					}
				}
			}
			
		}
		
	}
	
	public function batch_update_deviation_table($number, $start)
	{
		$this->db->limit(3000, 0);
		//$this->db->select('ISBN, User-ID userid');
		$this->db->from('bx-book-ratings');
		$this->db->where('Book-Rating <> 0');
		$query = $this->db->get();
				
		echo $query->num_rows();
		//za svaki slog poziva se azuriranje parova
		if($query->num_rows() > 0)
		{
			$i = 0;
			foreach($query->result() as $rating)
			{	
				$this->db->insert('temp', $rating);
				
				$this->db->select('ISBN, User-ID userid');
				$this->db->from('temp');
				$this->db->where('ISBN', $rating->ISBN);
				
				$query = $this->db->get();
				$row = $query->row();
								
				$this->update_deviation_table($row->ISBN, $row->userid, $i);
			}
			echo 'napustio foreach <br />';
		}
		echo $i;
	}
	
	public function partial_update_deviation_table($number = 1000, $start = 0)
	{
		$this->batch_update_deviation_table($number, $start);
	}
	
	public function non_personalized_recommendation($isbn)
	{
		$this->db->limit(5);
		$this->db->select('bx-books.ISBN, Book-Title, Book-Author, Image-URL-M, `sum`/`count`');
		$this->db->from('deviation');
		$this->db->join('bx-books', 'deviation.ISBN2 = bx-books.ISBN');
		$this->db->where('ISBN1', $isbn);
		$this->db->where('ISBN2 != ', $isbn);
		$this->db->where('count > 0');
		$this->db->order_by('`sum`/`count`', 'desc');
		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function predict_all($userid, $top = 0)
	{
		$this->db->select('d.ISBN1 as `knjiga`, sum(d.sum + d.count * r.`Book-Rating`)/sum(`d`.`count`) AS `prosjek`, b.`ISBN`, Book-Title, Book-Author, Ratings_Sum, Reviews_Number, Image-URL-S');
		$this->db->from('deviation d, bx-book-ratings r, bx-books b');
		$this->db->where('d.ISBN1 = b.ISBN');
		$this->db->where('d.ISBN2 = r.ISBN');
		
		$this->db->where('r.User-ID', $userid);
		$this->db->where('d.ISBN1 NOT IN (SELECT ISBN from `bx-book-ratings` WHERE `User-ID` = '.$userid.')');
		
		$this->db->group_by('`d`.`ISBN1`, b.`ISBN`, `Book-Title`, `Book-Author`, `Ratings_Sum`, `Reviews_Number`, `Image-URL-S`');
		if($top != 0)
		{
			$this->db->order_by('prosjek', 'desc');
			$this->db->limit($top);
		}
		
		$query = $this->db->get();
		return $query;
	}
	
	public function predict_single($userid, $isbn)
	{
		$denom = 0;
		$numer = 0;
		$k = $isbn;
		
		$this->db->select('r.ISBN isbn, r.Book-Rating rating');
		$this->db->from('bx-book-ratings r');
		$this->db->where('r.User-ID', $userid);
		$this->db->where('r.ISBN <>', $isbn);
		
		$query = $this->db->get();
		
		foreach($query->result() as $review)
		{
			$j = $review->isbn;
			$rating = $review->rating;
			
			$this->db->select('d.count, d.sum');
			$this->db->from('deviation d');
			$this->db->where('ISBN1', $k);
			$this->db->where('ISBN2', $j);
			$query2 = $this->db->get();
			
			if($query2->num_rows() > 0)
			{
				$result = $query2->row();
				$count = $result->count;
				$sum = $result->sum;
				$average = $sum/$count;
				$denom += $count;
				$numer += $count * ($average + $review->rating);
			}
		}
		
		if($denom == 0) return 0;
		else return $numer/$denom;
	}
	
	public function get_top_books($userid, $top)
	{
		return $this->predict_all($userid, $top)->result_array();
	}
	
	public function recommend_popular()
	{
		$this->db->limit(5);
		$this->db->distinct();
		$this->db->select('bx-books.ISBN ISBN, Book-Title, Image-URL-M');
		$this->db->from('bx-books, bx-book-ratings');
		$this->db->where('`bx-books`.`ISBN` = `bx-book-ratings`.`ISBN`');
		$this->db->where('`Ratings_Sum`/`Reviews_Number` > 8');
		$this->db->where('DATE_SUB(CURDATE(),INTERVAL 720 DAY) >= `bx-book-ratings`.DateTime');
		//$this->db->having('count(*) > 50');
		//$this->db->group_by('bx-books.ISBN, Book-Title, Image-URL-M');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function user_similarity($userid1, $userid2)
	{
		$this->db->select('b.ISBN');
		$this->db->from('bx-book-ratings r1');
		$this->db->join('(select * from `bx-book-ratings`) r2', 'r1.ISBN = r2.`ISBN`');
		$this->db->join('bx-books b', 'r1.ISBN = b.ISBN');
		$this->db->where('r1.User-ID', $userid1);
		$this->db->where('r2.User-ID', $userid2);
		$this->db->where('r1.Book-Rating <> 0');
		$this->db->where('r2.Book-Rating <> 0');
		$query = $this->db->get();
		
		if($query->num_rows() == 0) $pearson = 0;
		
		else
		{
			$sum1 = 0;
			$squareSum1 = 0;
			
			$sum2 = 0;
			$squareSum2 = 0;
			
			$productsSum = 0;
			
			foreach($query->result() as $review)
			{
				$this->db->select('Book-Rating rating');
				$this->db->from('bx-book-ratings');
				$this->db->where('User-ID', $userid1);
				$this->db->where('ISBN', $review->ISBN);
				$query1 = $this->db->get();
				$row1 = $query1->row();
				$rating1 = $row1->rating;
				
				$sum1 += $rating1;
				$squareSum1 += pow($rating1, 2);
				
				$this->db->select('Book-Rating rating');
				$this->db->from('bx-book-ratings');
				$this->db->where('User-ID', $userid2);
				$this->db->where('ISBN', $review->ISBN);
				$query2 = $this->db->get();
				$row2 = $query2->row();
				$rating2 = $row2->rating;
				
				$sum2 += $rating2;
				$squareSum2 += pow($rating2, 2);
				
				$productsSum += $rating1 * $rating2;
			}
			
			$numerator = $productsSum - ($sum1 * $sum2 / $query->num_rows());
			$denominator = sqrt( ($squareSum1 - pow($sum1, 2)/$query->num_rows()) * ($squareSum2 - pow($sum2, 2)/$query->num_rows()) );
									
			if($denominator == 0) $pearson = 0;
			
			else $pearson = $numerator / $denominator;
		}
		
		return $pearson;
	}
	
	public function update_pearson($userid, $ISBN)
	{
		$this->db->distinct();
		$this->db->select('bx-users.User-ID userid');
		$this->db->from('bx-users, bx-book-ratings');
		$this->db->where('`bx-users`.`User-ID` = `bx-book-ratings`.`User-ID`');
		$this->db->where('bx-book-ratings.ISBN', $ISBN);
		$this->db->where('`bx-users`.`User-ID` !=', $userid);
		$query = $this->db->get();

		foreach($query->result() as $user)
		{
			$this->db->from('pearson');
			$this->db->where('User-ID1', $userid);
			$this->db->where('User-ID2', $user->userid);
			$query2 = $this->db->get();
			
			$data = array(
				 'User-ID1' => $userid,
				 'User-ID2' => $user->userid,
				 'Correlation' => $this->user_similarity($userid, $user->userid)
			);
				
			$data2 = array(
				 'User-ID1' => $user->userid,
				 'User-ID2' => $userid,
				 'Correlation' => $this->user_similarity($userid, $user->userid)
			);
			
			if($query2->num_rows == 0)
			{
				$this->db->insert('pearson', $data);
				$this->db->insert('pearson', $data2);
			}
			
			else
			{
				$this->db->where('User-ID1', $userid);
				$this->db->where('User-ID2', $user->userid);
				$this->db->update('pearson', $data);
				
				$this->db->where('User-ID1', $user->userid);
				$this->db->where('User-ID2', $userid);
				$this->db->update('pearson', $data2);
			}
		}
	}
	
	public function recommend_users($userid, $top = 0)
	{
		$this->db->select('`bx-users`.`User-ID` userid, `bx-users`.Username, `bx-users`.`Avatar`');
		$this->db->from('Pearson, `bx-users`');
		$this->db->where('`Pearson`.`User-ID2` = `bx-users`.`User-ID`');
		$this->db->where('`User-ID1`', $userid);
		if($top != 0)
		{
			$this->db->order_by('Correlation', 'desc');
			$this->db->limit($top);
		}
		
		$query2 = $this->db->get();
		return $query2->result_array();
	}
		
	public function get_reviews($config, $userid = 0) {
		$this->db->select('bx-users.User-ID, Username, Avatar, bx-book-ratings.ISBN, Book-Rating, Book-Title, Image-URL-S, Book-Author');
		$this->db->from('bx-book-ratings, bx-books, bx-users');
		
		if($userid != 0) $this->db->where('bx-book-ratings.User-ID', $userid);
		
		$this->db->where('`bx-book-ratings`.`User-ID` = `bx-users`.`User-ID`');
		$this->db->where('`bx-book-ratings`.`ISBN` = `bx-books`.`ISBN`');
		$this->db->order_by('bx-book-ratings.DateTime', 'desc');
		$this->db->limit($config['per_page'], $config['offset']);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_reviews_number($userid = 0) {
		$this->db->from('bx-book-ratings');
		
		if($userid != 0) $this->db->where('bx-book-ratings.User-ID', $userid);
		
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function get_friends_reviews($config) {
		$this->db->select('bx-users.User-ID, Username, Avatar, bx-book-ratings.ISBN, Book-Rating, Book-Title, Image-URL-S, Book-Author');
		$this->db->from('bx-book-ratings, bx-books, bx-users, friendship');
		
		$this->db->where('`bx-users`.`User-ID` = `friendship`.`User2`');
		$this->db->where('`bx-book-ratings`.`User-ID` = `friendship`.`User2`');
		$this->db->where('friendship.User1', $this->session->userdata('userid'));
		$this->db->where('friendship.Confirmed', 1);
		
		$this->db->where('`bx-book-ratings`.`User-ID` = `bx-users`.`User-ID`');
		$this->db->where('`bx-book-ratings`.`ISBN` = `bx-books`.`ISBN`');
		
		$this->db->limit($config['per_page'], $config['offset']);		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_friends_reviews_number() {
		$this->db->from('bx-book-ratings, bx-users, friendship');
		$this->db->where('`bx-users`.`User-ID` = `friendship`.`User2`');
		$this->db->where('friendship.User1', $this->session->userdata('userid'));
		$this->db->where('friendship.Confirmed', 1);
				
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function user_reviews($config, $userid) {
		return $this->get_reviews($config, $userid);
	}
	
	public function user_reviews_number($userid) {
		return $this->get_reviews_number($userid);
	}
	
	public function get_book_reviews($config, $ISBN) {
		$this->db->select('bx-users.User-ID, Username, Avatar, bx-book-ratings.ISBN, Book-Rating, Book-Title, Image-URL-S, Book-Author');
		$this->db->from('bx-book-ratings, bx-books, bx-users');
		
		$this->db->where('bx-book-ratings.ISBN', $ISBN);
		
		$this->db->where('`bx-book-ratings`.`User-ID` = `bx-users`.`User-ID`');
		$this->db->where('`bx-book-ratings`.`ISBN` = `bx-books`.`ISBN`');
		$this->db->limit($config['per_page'], $config['offset']);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_book_reviews_number($ISBN) {
		$this->db->from('bx-book-ratings');
		$this->db->where('bx-book-ratings.ISBN', $ISBN);
		
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function get_review($isbn, $userid) {
		$this->db->select('bx-books.ISBN, Book-Author, Book-Title, Image-URL-M, bx-users.User-ID AS UserID, Username, Avatar, Book-Rating, Review');
		$this->db->from('bx-books, bx-users, bx-book-ratings');
		
		$this->db->where('`bx-books`.`ISBN` = `bx-book-ratings`.`ISBN`');
		$this->db->where('`bx-users`.`User-ID` = `bx-book-ratings`.`User-ID` ');
		
		$this->db->where('bx-book-ratings.ISBN', $isbn);
		$this->db->where('bx-book-ratings.User-ID', $userid);
		
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function get_comments($isbn, $userid) {
		$this->db->select('Username, Avatar, Content, comments.DateTime');
		$this->db->from('comments, bx-users');
		$this->db->where('`comments`.`Commenter-ID` = `bx-users`.`User-ID`');
		$this->db->where('comments.ISBN', $isbn);
		$this->db->where('comments.User-ID', $userid);
		$this->db->order_by('DateTime', 'asc');
		
		$query = $this->db->get();
		return $query->result_array();
	}
}
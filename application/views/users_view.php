	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script>
		function friend(User1, User2, DateTime, Confirmed)
		{
			$.post('<?php echo base_url(); ?>users/friend_request/', { 'User1' : User1, 'User2' : User2, 'DateTime' : DateTime, 'Confirmed' : Confirmed },
				function(data){
				}, 'json');
			$('#friend'.concat(User2)).replaceWith('<strong><font color=\"blue\">Zahtjev poslan!</font></strong>');
		}
	</script>
	<div class="container">
		<?php foreach($users as $user): ?>
			<div class="row">
				<div class="span2"> <a href="<?php echo base_url() ?>users/profile/<?php echo $user['User-ID']; ?>"><img src="<?php echo base_url() ?>assets/images/user-avatars/<?php echo $user['Avatar']; ?>.jpg" class="img-polaroid"/> </a></div>
				<div class="span2">
					<a href="<?php echo base_url(); ?>reviews/user_reviews/<?php echo $user['User-ID']; ?>"><strong style="font-size: 18px"> <?php echo $user['Username'] ?> </strong></a>
					<br /><br />
				</div>
				<div class="span4">
					<div>Lokacija:</div>
					<?php echo $user['Location']; ?>
				</div>
				<div class="span2">
					<div>Godine:</div>
					<?php if ($user['Age']) echo $user['Age']; else echo "-"; ?>
				</div>
				<div class="span2">
					<input type="button" name="friend<?php echo $user['User-ID']; ?>" id="friend<?php echo $user['User-ID']; ?>" class="btn btn-primary" value="Dodaj prijatelja" onclick="friend(<?php echo $this->session->userdata('userid'); ?>, <?php echo $user['User-ID']; ?>, <?php echo date('Y-m-d'); ?>, 0)" />
				</div>
			</div>
			<hr />
		<?php endforeach ?>
		<div class="row span6">
			<div class="pagination">
				<?php echo $this->pagination->create_links(); ?>
			</div>
		</div>
	</div>
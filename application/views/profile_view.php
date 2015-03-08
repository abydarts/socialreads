<div class="container">
		<div class="row">
			<div class="span2"> <img src="<?php echo base_url() ?>assets/images/user-avatars/<?php echo $user['Avatar']; ?>.jpg" class="img-polaroid"/> </div>
			<div class="span2">
				<a href="<?php echo base_url(); ?>reviews/user_reviews/<?php echo $user['User-ID']; ?>"><strong style="font-size: 18px"> <?php echo $user['Username'] ?> </strong></a>
				<br /><br />
			</div>
			<div class="span2">
				<div>Lokacija:</div>
				<?php echo $user['Location']; ?>
			</div>
			<div class="span2">
				<div>Prijatelji od:</div>
				<?php echo $user['DateTime']; ?>
			</div>
			<div class="span2">
				<div>Godine:</div>
				<?php echo $user['Age']; ?>
			</div>
			<div class="span2">
				<form action="<?php echo base_url() ?>users/write_message" method="POST">
					<button class="btn btn-info">Pošalji poruku</button>
					<input type="hidden" id="user" name="user" value="<?php echo $user['User-ID']; ?>" />
				</form>
				<form action="<?php echo base_url() ?>RECENZIJE" method="POST">
					<input type="button" name="friend<?php echo $user['User-ID']; ?>" id="friend<?php echo $user['User-ID']; ?>" class="btn btn-primary" value="Ukloni iz prijatelja" onclick="unfriend(<?php echo $this->session->userdata('userid'); ?>, <?php echo $user['User-ID']; ?>, <?php echo date('Y-m-d'); ?>, 0)" />
				</form>
			</div>
		</div>
		<hr />
		<div><strong>PRIJATELJI</strong></div><br />
		<div class="span12">
			<?php foreach($friends as $friend): ?>
				<?php if($friend['User-ID'] != $this->session->userdata('userid')) { ?>
				<div class="span1">
					<a href="<?php echo base_url() ?>users/profile/<?php echo $friend['User-ID']; ?>"><img src="<?php echo base_url() ?>assets/images/user-avatars/<?php echo $friend['Avatar']; ?>.jpg" class="img-polaroid"/> </a>
				</div>
				<?php } ?>
			<?php endforeach; ?>
		</div>
		
		<div class="span12">
			<?php foreach($friends as $friend): ?>
				<?php if($friend['User-ID'] != $this->session->userdata('userid')) { ?>
				<div class="span1">
					<?php echo $friend['Username'] ?>
				</div>
				<?php } ?>
			<?php endforeach; ?>
		</div>
	<div class="container">
		<strong><font color="#7F7F7F">PREPORUČENI PRIJATELJI</font></strong><br /><hr />
		<?php $i = 0; ?>
		<?php foreach($users as $user): ?>
		<?php if($i == 0) { ?> <div class="row"> <?php } ?>
		
			<div class="span1"><a href="<?php echo base_url(); ?>reviews/user_reviews/<?php echo $user['userid']; ?>"><strong style="font-size: 18px"> <?php echo $user['Username'] ?> </strong></a></div>
			<div class="span2"> <img src="<?php echo base_url() ?>assets/images/user-avatars/<?php echo $user['Avatar']; ?>.jpg" class="img-polaroid"/> </div>
		
		<?php $i++; if($i == 4) $i = 0; ?>
		<?php if($i == 0) { ?> </div> <hr /> <?php } ?>
		<?php endforeach ?>

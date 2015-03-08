	<div class="container">
		<?php foreach($reviews as $review): ?>
			<div class="row">
				<div class="span1"> <a href="<?php echo base_url() ?>users/profile/<?php echo $review['User-ID']; ?>"><img src="<?php echo base_url() ?>assets/images/user-avatars/<?php echo $review['Avatar']; ?>.jpg" class="img-polaroid"/> </a></div>
				<div class="span2">
					<a href="<?php echo base_url(); ?>reviews/user_reviews/<?php echo $review['User-ID']; ?>"><strong style="font-size: 18px"> <?php echo $review['Username'] ?> </strong></a>
				</div>
				<div class="span1">
					<img src="<?php echo $review['Image-URL-S']; ?>" class="img-polaroid"/> 
				</div>
				<div class="span2">
					<a href="<?php echo base_url(); ?>books/book/<?php echo $review['ISBN']; ?>"><strong><?php echo $review['Book-Title']; ?></strong></a> - 
					<?php echo $review['Book-Author']; ?>
				</div>
				<div class="span2">
					Ocjena: <strong><?php if($review['Book-Rating']) echo $review['Book-Rating']; else echo "-"; ?></strong>
				</div>
				<div class="span2">
					<a href="<?php echo base_url() ?>reviews/review/<?php echo $review['ISBN']; ?>/<?php echo $review['User-ID']; ?>">Pročitaj recenziju</a>
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
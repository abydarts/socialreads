		<div class="row">
			<div class="span6">
				<strong><font color="#7F7F7F">Također preporučujemo:</font></strong>
			</div>
		</div>
		 
		<br />
		
		<div class="row">
			<div class="span12">
				<div class="row">
				<div>
					<div class="span12">
						<?php foreach($preporuke as $preporuka): ?>
							<div class="span2">
								<a href="<?php echo base_url(); ?>books/book/<?php echo $preporuka['ISBN']; ?>">
								<?php $slika = $preporuka['Image-URL-M']; ?>
								<img src="<?php $size = (getimagesize($slika)); list($width,$height) = $size; if($height != 1 && $width != 1) echo $preporuka['Image-URL-M']; else echo base_url()."assets/images/empty.jpg"; ?>"></img></a>
								&nbsp;&nbsp;&nbsp;
							</div>
						<?php endforeach ?>
					</div>
					<div class="span12">
						<?php foreach($preporuke as $preporuka): ?>
							<div class="span2">
								<a href="<?php echo base_url(); ?>books/book/<?php echo $preporuka['ISBN']; ?>"><?php echo $preporuka['Book-Title'] ?></a>
							</div>
						<?php endforeach ?>
				</div>
			</div>
			</div>
		</div>
	</div>
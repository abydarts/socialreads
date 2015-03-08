	<div class="container">
		<strong><font color="#7F7F7F">PREPORUČUJEMO NA OSNOVU VAŠIH OCJENA</font></strong><br /><hr />
		<?php $i = 0; ?>
		<?php foreach($books as $book): ?>
		<?php if($i == 0) { ?> <div class="row"> <?php } ?>
				<div class="span1">
					<a href="<?php echo base_url(); ?>books/book/<?php echo $book['ISBN']; ?>">
					<?php $slika = $book['Image-URL-S']; ?>
					<img src="<?php $size = (getimagesize($slika)); list($width,$height) = $size; if($height != 1 && $width != 1) echo $book['Image-URL-S']; else echo base_url()."assets/images/empty.jpg"; ?>"></img></a>
					&nbsp;&nbsp;&nbsp;
				</div>
				<div class="span2">
					<a href="<?php echo base_url(); ?>books/book/<?php echo $book['ISBN']; ?>"> <strong><?php echo $book['Book-Title'] ?> </strong></a>
					<br />
					<div><strong><?php echo $book['Book-Author'] ?></strong> </div>
					<div>Ocjena:
						<?php if($book['Ratings_Sum']) { echo "<strong>"; echo number_format($book['Ratings_Sum']/$book['Reviews_Number'], 2); echo "</strong>";}
								else echo "-" ?></div>
					<br />
				</div>
		<?php $i++; if($i == 4) $i = 0; ?>
		<?php if($i == 0) { ?> </div> <hr /> <?php } ?>
		<?php endforeach ?>
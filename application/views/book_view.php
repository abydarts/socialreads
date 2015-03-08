	<div class="container">
		<div class="row">
			<div class="span2">
				<a href="<?php echo base_url(); ?>books/book/<?php echo $knjiga['ISBN']; ?>">
				<?php $slika = $knjiga['Image-URL-M']; ?>
				<img src="<?php $size = (getimagesize($slika)); list($width,$height) = $size; if($height != 1 && $width != 1) echo $knjiga['Image-URL-M']; else echo base_url()."assets/images/empty.jpg"; ?>"></img></a>
				&nbsp;&nbsp;&nbsp;
			</div>
			<div class="span4">
				<strong style="font-size: 18px"> <?php echo $knjiga['Book-Title'] ?> </strong>
				<br /><br />
				<div><?php echo $knjiga['Book-Author'] ?> </div>
				<br />
				<div>ISBN: <?php echo $knjiga['ISBN'] ?> </div>
			</div>
			<div class="span2">
				<div>Izdavač:</div>
				<?php echo $knjiga['Publisher'].'<br /> ('.$knjiga['Year-Of-Publication'].')'; ?>
			</div>
			<div class="span2">
				<div>Prosječna ocjena:</div>
				<div><?php if($knjiga['Ratings_Sum']) { echo "<strong>"; echo number_format($knjiga['Ratings_Sum']/$knjiga['Reviews_Number'], 2); echo "</strong>"; echo " (".$knjiga['Reviews_Number']." korisnika)";}
							else echo "-"; ?>
				</div>
				<br />
				<?php if($prosjek != 0) { ?>
				<div>Vaša predviđena ocjena:</div>
				<div><?php //if($prosjek < 0) echo '1'; if($prosjek > 10) echo '10'; else
				echo $prosjek; ?></div>
				<?php } ?>
			</div>
			<div class="span2">
				<form action="<?php echo base_url() ?>books/recenziranje" method="POST">
					<input type="hidden" name="isbn" id="isbn" value="<?php echo $knjiga['ISBN']; ?>" />
					<button class="btn btn-primary">Recenziraj</button>
				</form>
				<form target="_blank" action="http://www.amazon.com/gp/aws/cart/add.html?AssociateTag=your-tag-here-20&ASIN.1=<?php echo $knjiga['ISBN'] ?>&Quantity.1=1" method="POST">
					<button class="btn btn-info"><i class="icon-shopping-cart"></i> Kupi</button>
				</form>
			</div>
		</div>
		
		<hr />

		<div class="row">
			<?php echo simplexml_load_file('http://www.lipsum.com/feed/xml?amount=1&what=paras&start=0')->lipsum.'..'; ?>
			<a href="<?php echo base_url() ?>reviews/book_reviews/<?php echo $knjiga['ISBN']; ?>">RECENZIJE</a>
		</div>
		<hr />
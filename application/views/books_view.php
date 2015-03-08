	<div class="container">
		<?php foreach($books as $book): ?>
			<div class="row">
				<div class="span2"> <img src="<?php echo $book['Image-URL-M']; ?>" class="img-polaroid"/> </div>
				<div class="span4">
					<a href="<?php echo base_url(); ?>books/book/<?php echo $book['ISBN']; ?>"><strong style="font-size: 18px"> <?php echo $book['Book-Title'] ?> </strong></a>
					<br /><br />
					<div><?php echo $book['Book-Author'] ?> </div>
					<br />
					<div>ISBN: <?php echo $book['ISBN'] ?> </div>
				</div>
				<div class="span2">
					<div>Izdavač:</div>
					<?php echo $book['Publisher'].'<br /> ('.$book['Year-Of-Publication'].')'; ?>
				</div>
				<div class="span2">
					<div>Prosječna ocjena:</div>
					<div><?php if($book['Ratings_Sum']) { echo "<strong>"; echo number_format($book['Ratings_Sum']/$book['Reviews_Number'], 2); echo "</strong>"; echo " (".$book['Reviews_Number']." korisnika)";}
								else echo "-" ?></div>
				</div>
				<div class="span2">
					<form action="<?php echo base_url() ?>books/recenziranje" method="POST">
						<input type="hidden" name="isbn" id="isbn" value="<?php echo $book['ISBN']; ?>" />
						<button class="btn btn-primary">Recenziraj</button>
					</form>
					<form target="_blank" action="http://www.amazon.com/gp/aws/cart/add.html?AssociateTag=your-tag-here-20&ASIN.1=<?php echo $book['ISBN'] ?>&Quantity.1=1" method="POST">
						<button class="btn btn-info"><i class="icon-shopping-cart"></i> Kupi</button>
					</form>
				</div>
			</div>
			<hr />
		<?php endforeach ?>
		<div class="row span6">
			<div class="pagination">
				<?php echo $this->pagination->create_links(); ?>
			</div>
		</div>
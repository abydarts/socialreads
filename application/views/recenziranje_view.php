	<div class="container">
		<div class="row">
			<form>
				<div class="span3">
					<a href="<?php echo base_url(); ?>books/book/<?php echo $knjiga['ISBN']; ?>"><h3><?php echo $knjiga['Book-Title'] ?></h3></a>
					<div>Autor: <?php echo $knjiga['Book-Author'] ?></div>
					<div>ISBN: <?php echo $knjiga['ISBN'] ?></div>
					<br />
					<div><img src="<?php echo $knjiga['Image-URL-M']; ?>" class="img-polaroid"/></div>
				</div>
				
				<form>
				</form>
				
				<div class="span4">
					<br />
					<form action="<?php echo base_url(); ?>books/postavi_recenziju" method="POST">
						<fieldset>
							<input type="hidden" name="isbn" id="isbn" value="<?php echo $knjiga['ISBN']; ?>" />
							<div><textarea rows="10" class="field span6" name="review" id="review"></textarea></div>
							<div>Ocjena:</div>
							<div class="rating">
								<input type="radio" name="radiobutton" id="star-10" value="10"/><label for="star-10"></label>
								<input type="radio" name="radiobutton" id="star-9" value="9"/><label for="star-9"></label>
								<input type="radio" name="radiobutton" id="star-8" value="8"/><label for="star-8"></label>
								<input type="radio" name="radiobutton" id="star-7" value="7"/><label for="star-7"></label>
								<input type="radio" name="radiobutton" id="star-6" value="6"/><label for="star-6"></label>
								<input type="radio" name="radiobutton" id="star-5" value="5"/><label for="star-5"></label>
								<input type="radio" name="radiobutton" id="star-4" value="4"/><label for="star-4"></label>
								<input type="radio" name="radiobutton" id="star-3" value="3"/><label for="star-3"></label>
								<input type="radio" name="radiobutton" id="star-2" value="2"/><label for="star-2"></label>
								<input type="radio" name="radiobutton" id="star-1" value="1"/><label for="star-1"></label>
							</div>
							<br /><br />
							<input type="submit" class="btn btn-primary" value="Postavi recenziju" />
						</fieldset>
					</form>
				</div>
			</form>
		</div>
		<hr />
	</div>
	<div class="container">
		<div class="row">
			<div class="span3">
				<h2>Knjige</h2>
				<p>Pregledajte informacije o najnovijim knjigama, kupite ih i recenzirajte: <a href="<?php echo base_url(); ?>books">Nove knjige</a></p>
			</div>
			<div class="span3">
				<h2>Recenzije</h2>
				<p>Pregledajte najnovije recenzije i ostavite komentar na recenzije prijatelja: <a href="<?php echo base_url(); ?>reviews">Nove recenzije</a></p>
			</div>
			<div class="span3">
				<h2>Poruke</h2>
				<p>Komunicirajte sa prijateljima i osobama sa sličnim interesovanjima: <a href="<?php echo base_url(); ?>users/write_message">Pošalji poruku</a></p>
			</div>
			<div class="span3">
				<h2>Preporuke</h2>
				<p>Pregledajte listu preporučene literature i korisnika: <a href="<?php echo base_url(); ?>books/recommendations">Preporučene knjige</a>, <a href="<?php echo base_url(); ?>users/recommendations">Preporučeni korisnici</a></p>
			</div>
		</div>
		
		<?php if($this->session->userdata('is_admin') == true) { ?>
		<a href="<?php echo base_url(); ?>reviews/import_reviews_to_deviation">UNESI SVE IZ BAZE</a> <br />
		<br /><br /><br />
		<?php } ?>
				 
		<hr />
		
		<div class="row">
			<div class="span2">
				<strong>Popularno</strong>
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

		<hr />
		
		<div class="row">
			<div class="span12">
				<button class="btn btn-facebook"><i class="icon-facebook"></i> | Facebook</button> &nbsp; &nbsp;
				<button class="btn btn-twitter"><i class="icon-twitter"></i> |  Twitter</button> &nbsp; &nbsp;
				<button class="btn btn-google-plus"><i class="icon-google-plus"></i> |  Google Plus</button> &nbsp; &nbsp;
				<button class="btn btn-instagram"><i class="icon-instagram"></i> |  Instagram</button> &nbsp; &nbsp;
				<button class="btn btn-pinterest"><i class="icon-pinterest"></i> |  Pinterest</button> &nbsp; &nbsp;
			</div>			
		</div>
	</div>
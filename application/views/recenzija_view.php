	<div class="container">
		<div class="row">
			<div class="span3">
				<h3><?php echo $recenzija['Book-Title'] ?></h3>
				<div>Autor: <?php echo $recenzija['Book-Author'] ?></div>
				<div>ISBN: <?php echo $recenzija['ISBN'] ?></div>
				<br />
				<div><img src="<?php echo $recenzija['Image-URL-M']; ?>" class="img-polaroid"/></div>
			</div>
			
			<form>
			</form>
			
			<div class="span9">
				<div><img src="<?php echo base_url() ?>assets/images/user-avatars/<?php echo $recenzija['Avatar']; ?>.jpg" class="img-polaroid"/>
				<strong><?php echo $recenzija['Username'] ?></strong></div><br />
				<div>Ocjena: <strong><?php if($recenzija['Book-Rating']) echo $recenzija['Book-Rating']; else echo "-"; ?></div></strong><br />
				<div><?php if($recenzija['Review'] == '') echo simplexml_load_file('http://www.lipsum.com/feed/xml?amount=1&what=paras&start=0')->lipsum;
							else echo $recenzija['Review']; ?></div>
			</div>
		</div>
			
			<div class="span10 offset2">
				<br /><br />
				<table class="table">
					<?php foreach($komentari as $komentar): ?>
						<tr class="success">
							<td class="span1"><img src="<?php echo base_url() ?>assets/images/user-avatars/<?php echo $komentar['Avatar']; ?>.jpg" class="img-polaroid"/></td>
							<td class="span1"><strong><?php echo $komentar['Username']; ?></strong></td>
							<td class="span7"><?php echo $komentar['Content']; ?></td>
						</tr>
					<?php endforeach ?>
				</table>
			</div>
			
			<div class="span6 offset3">
				<?php if($recenzija['prijatelj'] || $recenzija['ja']) { ?>
					<br />
					<form action="<?php echo base_url(); ?>reviews/postavi_komentar" method="POST">
							<fieldset>
								<div><textarea rows="5" class="field span6" name="review" id="review"></textarea></div>
								<input type="hidden" name="userid" value="<?php echo $recenzija['UserID'] ?>" />
								<input type="hidden" name="isbn" value="<?php echo $recenzija['ISBN'] ?>" />
								<input type="submit" class="btn btn-primary" value="Postavi komentar" />
							</fieldset>
					</form>
				<?php } ?>
			</div>
	</div>
<div class="container">
		<div class="row">
			<div class="span4">
					<br />
					<form action="<?php echo base_url(); ?>users/send_message" method="POST">
						<fieldset>
							<div>Prijatelj:</div>
							<select name = "User-ID" id = "User-ID">
								<?php foreach($friends as $friend):?>
									<option value = "<?php echo $friend['User-ID']; ?>" <?php if($user != 0 && $user == $friend['User-ID']) echo "selected" ?> ><?php echo $friend['Username']; ?></option>
								<?php endforeach; ?>
							</select>
							<div>Naslov poruke:</div>
							<div><input type="text" id="Subject" name="Subject" class="field span6"></input></div>
							<div>Poruka:</div>
							<div><textarea id="Content" name="Content" rows="10" class="field span6" name="review" id="review"></textarea></div>
							<input type="submit" class="btn btn-primary" value="Pošalji poruku" />
					</form>
			</div>
		</div>
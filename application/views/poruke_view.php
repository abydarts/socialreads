	<div class="container">
		<div class="row">
			<div class="span12">
				<table class="table">
					<?php foreach($poruke as $poruka): ?>
						<tr class="info">
							<td class="span2"><img src="<?php echo base_url() ?>assets/images/user-avatars/<?php echo $poruka['Avatar']; ?>.jpg" class="img-polaroid"/></td>
							<td class="span2"><?php echo $poruka['Username']; ?></td>
							<td class="span2"><?php echo $poruka['DateTime']; ?></td>
							<td class="span8"><a href="<?php echo base_url();?>users/view_message/<?php echo $poruka['ID']; ?>"><?php echo $poruka['Subject']; ?></a></td>
						</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
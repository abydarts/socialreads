	<div class="container">
		<div class="row">
			<div class="span12">
				<table class="table">
					<?php foreach($poruke as $poruka): ?>
						<tr class="warning">
							<td class="span2"><img src="<?php echo base_url() ?>assets/images/user-avatars/<?php echo $poruka['Avatar']; ?>.jpg" class="img-polaroid"/></td>
							<td class="span2"><?php if($poruka['Viewed'] == 0) echo "<strong>"; echo $poruka['Username']; if($poruka['Viewed'] == 0) echo "</strong>"; ?></td>
							<td class="span2"><?php if($poruka['Viewed'] == 0) echo "<strong>"; echo $poruka['DateTime']; if($poruka['Viewed'] == 0) echo "</strong>"; ?></td>
							<td class="span9"><a href="<?php echo base_url();?>users/view_message/<?php echo $poruka['ID']; ?>"><?php if($poruka['Viewed'] == 0) echo "<strong>"; echo $poruka['Subject']; if($poruka['Viewed'] == 0) echo "</strong>"; ?></a></td>
						</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
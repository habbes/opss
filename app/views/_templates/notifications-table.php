
<div class="table-responsive">
	<table class="table table-striped table-hover records-table" id="notifications-table">
		<?php if(count($data->messages) == 0 ) {?>
			No messages found.
		</table>
		<?php } else { ?>
		<thead>
			<tr>
				<th>Subject</th>
				<th>Date Sent</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($data->messages as $message) { ?>
			<tr>
				<td><?= $message->getSubject() ?></td>
				<td><?= Utils::dbDateFormat($message->getDateSent()) ?></td>
			</tr>
			<?php } //end foreach ?>
		</tbody>
		<?php } //end if-else block?>
	</table>

</div>

<div class="table-responsive">
	<table class="table table-striped table-hover records-table" id="notifications-table">
		<?php if(count($data->messages) == 0 ) {?>
			No messages found.
		</table>
		<?php } else { ?>
		<thead>
			<tr>
				<th style="width:80%">Subject</th>
				<th>Date Sent</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($data->messages as $message) { 
				$unread = $message->isRead()? "" : "unread";
			?>
			<tr class="<?= $unread ?>" data-id="<?= $message->getId() ?>">
				<td><?= $message->getSubject() ?></td>
				<td><?= Utils::siteDateFormat($message->getDateSent()) ?></td>
			</tr>
			<?php } //end foreach ?>
		</tbody>
		<?php } //end if-else block?>
	</table>

</div>
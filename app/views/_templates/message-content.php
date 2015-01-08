
<div class="message-content">
	<?= escape($data->message->getMessage())?>
</div>
<div class="message-time">
	Sent on <?= Utils::siteDateTimeFormat($data->message->getDateSent())?>
</div>
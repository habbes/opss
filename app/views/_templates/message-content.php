
<div class="message-content margin-bottom">
	<?= $data->message->getMessage()?>
</div>
<div class="message-parts margin-bottom">
<?php foreach($data->message->getParts() as $part){?>
	<div class="message-part">
	<?php switch($part["type"]){
		case Message::PART_PAPER:
			$paper = Paper::findById($part["args"]["id"]) or $paper = new DataObject();
	?>
	<a class="link" href="<?= $paper->getAbsoluteUrl()?>">View Paper: <?= $paper->getIdentifier() ?></a>
	<?php 
			break;
		case Message::PART_REVIEW_REQUEST:
			$request = ReviewRequest::findById($part["args"]["id"]) or $request = new DataObject();
	?>
		<a class="link" href="<?= $request->getAbsoluteUrl()?>">View Request</a>
	<?php 
			break;
		}
	?>
	
	</div>
<?php } ?>
</div>
<div class="message-time">
	Sent on <?= Utils::siteDateTimeFormat($data->message->getDateSent())?>
</div>
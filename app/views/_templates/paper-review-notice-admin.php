<div>
	<p>
		This paper is currently being reviewed by <strong><?= $data->reviewer->getFullName()?></strong>
		(since <?= Utils::siteDateFormat($data->review->getDateInitiated())?>).
		You will be notified when the reviewer has submitted recommendations.
	</p>
</div>
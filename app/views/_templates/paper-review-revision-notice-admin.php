<div>
	<p>
	This paper has been returned to the researcher after review for further revision. 
	The conclusion of the <a class="link" href="<?= $data->paperBaseUrl?>/reviews/<?= $data->review->getId()?>">review</a>
	was: <span class="font-bold"><?= Review::getVerdictString($data->review->getAdminVerdict())?></span>.<br>
	You will be notified when it has been resubmitted.
	</p>
</div>

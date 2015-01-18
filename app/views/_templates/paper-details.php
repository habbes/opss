<?php 
/**
 * @var Paper
 */
$paper = $data->paper;
?>
<div>
	<div>
		<span class="font-bold">Title</span><br>
		<?= $paper->getTitle()?>
	</div>
	<div>
		<span class="font-bold">Principle Researcher</span><br>
		<?= $paper->getResearcher()->getFullname()?>
	</div>
	<div>
		<span class="font-bold">Co-Authors</span><br>
		<?php if(count($paper->getAuthors()) == 0) {?>
			<i><?= "none"?></i>
		<?php } else { ?>
		<?php foreach($paper->getAuthors() as $author) {?>
			<?= $author->getName() . "(".$author->getEmail().")"?>
		<?php } ?>
		<?php } ?>
	</div>
	<div>
		<span class="font-bold">Language</span><br>
		<?= $paper->getLanguage()?>
	</div>
	<div>
		<span class="font-bold">Country of Research</span><br>
		<?= $paper->getCountry()?>
	</div>
</div>
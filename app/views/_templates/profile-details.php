<?php 
$user = $data->user;
$role = $user->getRole();
$activated = $user->isEmailActivated();
 ?>
<?php if(!$activated){?>
<p class="bg-danger text-danger" style="padding:3px" >
This account has not been activated. Check you email inbox (<?= $user->getEmail()?>) for an activation link. You will not be able to sign in again until you have
activated your email address.
</p>
<?php } ?>
<?php if($user->getPhoto()){?>
<div>
	<img src="<?= $user->getPhotoUrl()?>" height="100">
</div>
<?php } ?>
<div class="details-grid user-details">
	
	<div class="details-item">
		<span class="font-bold details-name">Name</span>
		<span class="details-value"><?= $user->getFullName() ?></span>
	</div>
	<div class="details-item">
		<span class="font-bold details-name">Role</span>
		<span class="details-value"><?= UserType::getString($user->getType()) ?></span>
	</div>
	<div class="details-item">
		<span class="font-bold details-name">Email</span>
		<span class="details-value">
		<span class="<?= (!$activated)? "bg-danger" : ""?>"><?= $user->getEmail() ?></span>
		<?php if($activated){?>
		<span class="glyphicon glyphicon-ok text-success"></span>
		<?php } ?>
		</span>
	</div>
	<div class="details-item">
		<span class="font-bold details-name">Username</span>
		<span class="details-value"><?= $user->getUsername() ?></span>
	</div>
	<?php if($role->hasGender()){?>
	<div class="details-item">
		<span class="font-bold details-name">Gender</span>
		<span class="details-value"><?= UserGender::getString($user->getGender()) ?></span>
	</div>
	<?php } ?>
	<div class="details-item">
		<span class="font-bold details-name">Date Joined</span>
		<span class="details-value"><?= Utils::siteDateFormat($user->getDateAdded()) ?></span>
	</div>
	<?php if($role->hasNationality()){?>
	<div class="details-item">
		<span class="font-bold details-name">Country of Nationality</span>
		<span class="details-value"><?= $user->getNationality() ?></span>
	</div>
	<?php } ?>
	<?php if($role->hasResidence()){?>
	<div class="details-item">
		<span class="font-bold details-name">Country of Residence</span>
		<span class="details-value"><?= $user->getResidence() ?></span>
	</div>
	<?php } ?>
	<?php if($role->hasAddress()){?>
	<div class="details-item">
		<span class="font-bold details-name">Address</span>
		<span class="details-value"><?= $user->getAddress() ?></span>
	</div>
	<?php } ?>
	<?php if($role->hasAreaOfSpecialization()){?>
	<div class="details-item">
		<span class="font-bold details-name">Thematic Area of Research</span>
		<span class="details-value">
		<?php foreach($user->getThematicAreas() as $area){?>
			<?= PaperGroup::getString($area)?><br>
		<?php } ?>
		</span>
	</div>
	<div class="details-item">
		<span class="font-bold details-name">Collaborative Area of Research</span>
		<span class="details-value">
		<?php foreach($user->getCollaborativeAreas() as $area){?>
			<?= PaperGroup::getString($area)?><br>
		<?php } ?>
		</span>
	</div>
	<?php } ?>
	
</div>
<div>
	<a href="<?= URL_ROOT?>/profile/edit" class="btn btn-default" >Edit Details <span class="glyphicon glyphicon-edit"></span></a>
</div>
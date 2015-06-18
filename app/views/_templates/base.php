<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$data->pageTitle?> - AERC OPSS</title>
        
	<link rel="stylesheet" type="text/css" href="<?=URL_PUBLIC?>/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?=URL_PUBLIC?>/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="<?=URL_PUBLIC?>/css/dashboard.css">
	<link rel="stylesheet" type="text/css" href="<?=URL_PUBLIC?>/css/theme.css">
        
	<script src="<?=URL_PUBLIC?>/js/jquery-1.11.2.min.js" type="text/javascript"></script>
	<script src="<?=URL_PUBLIC?>/js/passfort.js" type="text/javascript"></script>
	<script src="<?=URL_PUBLIC?>/js/base.js" type="text/javascript"></script>
	<script src="<?=URL_PUBLIC?>/js/ready.js" type="text/javascript"></script>
	<!-- 
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	-->
      
</head>
<body>

<div class="container-fluid" id="main-container">
	<header id="header">
		<div class="nav navbar-default navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header" id="logo-container">
					<a class="navbar-brand" href="<?=URL_ROOT?>"><img id="logo-image" src="<?=URL_PUBLIC?>/images/logo.png"/></a>
				</div>
				<ul class="nav navbar-nav" id="opss-title-container">
					<li>
						<h1 id="opss-title">Online Paper Submission System</h1>
					</li>
				</ul>
				
				<?php if($data->userName) {?>
				<!-- username profile and logout -->				
				<ul class="nav navbar-nav navbar-right" id="username-dropdown">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" 
							aria-expanded="false"><?php if($data->user->getPhoto()){?>
							<img src="<?=$data->userPhoto?>" height="30">&nbsp;
							<?php } ?>
							<?= $data->userName ?><span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?= URL_ROOT ?>/profile"><span class="glyphicon glyphicon-user"></span> My Profile</a></li>
							<li class="divider"></li>
							<li><a href="<?= URL_ROOT ?>/logout"><span class="glyphicon glyphicon-log-out"></span> Sign Out</a></li>
						</ul>
					
					</li>				
				</ul>				
				<?php } ?>
			
			</div>
		</div>
	</header>
	
	<div id="page-body">
		<?= $data->pageBody ?>
	</div>

</div>

<!-- popup modal window -->
<div class="modal" id="popup-viewer" role="modal" aria-labelledBy="popup-viewer-title" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" data-target="popup-viewer" 
					aria-label="Close"><span aria-hidden="true" >&times;</span></button>
				<h4 class="modal-title align-center" id="popup-viewer-title"></h4>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?=URL_ROOT?>/public/js/bootstrap.min.js"></script>
</body>
</html>
	
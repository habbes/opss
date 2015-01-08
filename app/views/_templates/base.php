<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$data->pageTitle?> - AERC OPSS</title>
        
        <link rel="stylesheet" type="text/css" href="<?=URL_PUBLIC?>/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?=URL_PUBLIC?>/css/dashboard.css">
        <link rel="stylesheet" type="text/css" href="<?=URL_PUBLIC?>/css/theme.css">
        
        <script src="<?=URL_PUBLIC?>/js/jquery-1.11.2.min.js" type="text/javascript"></script>
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
							aria-expanded="false"><?= $data->userName ?><span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?= URL_ROOT ?>/profile">My Profile</a></li>
							<li class="divider"></li>
							<li><a href="<?= URL_ROOT ?>/logout">Sign Out</a></li>
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

<script type="text/javascript" src="<?=URL_ROOT?>/public/js/bootstrap.min.js"></script>
</body>
</html>
	
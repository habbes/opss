<?php 

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?=$data->pageTitle?></title>
        <link rel="stylesheet" type="text/css" href="<?=URL_ROOT?>/public/css/home.css">
        <link rel="stylesheet" type="text/css" href="<?=URL_ROOT?>/public/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?=URL_ROOT?>/public/css/dashboard.css">
        <link rel="stylesheet" type="text/css" href="<?=URL_ROOT?>/public/css/bootstrap-theme.min.css">
        <script type="text/javascript" src="<?=URL_ROOT?>/public/js/bootstrap.min.js"></script>
        
        <!-- 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
		-->
      
</head>
<body>
<div class="navbar navbar-fixed-top" id="header" role="navigation">
    <ul class="nav nav-tabs">
        <li class="dropdown pull-right">
            <a href="#" data-toggle="dropdown" class="dropdown-toggle"><?=$data->userName?><b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="#">Profile</a></li>
                <li class="divider"></li>
                <li><a href="#">Log out</a></li>
            </ul>
        </li>
    </ul>
</div>
<div class="container-fluid">
	<div class="row">
	<?=$data->pageBody;?>
	</div>
</div>
<div id="footer">
	<div class="col-sm-5 col-sm-offset-4">
		<p class="muted credit">Contact us on <a href="mailto:research@aercafrica.org">research@aercafrica.org</a></p>
	</div>
</div>

</body>
</html>
	
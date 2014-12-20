<?php 

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?=$data->pageTitle?></title>
		<!--<base href="http://localhost/mvc/project/public/" >-->
        <link rel="stylesheet" type="text/css" href="http://localhost/mvc/project/public/css/home.css">
        <link rel="stylesheet" type="text/css" href="http://localhost/mvc/project/public/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="http://localhost/mvc/project/public/css/dashboard.css">
        <!-- <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">-->
	<style type="text/css">
	#bs-example{
    	background-color: #fff;
    }
    hr{
        margin: 60px 0;
    }
</style>
</head>
<body>
<div class="navbar navbar-fixed-top" id="bs-example" role="navigation">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#">Home</a></li>
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
		<p class="muted credit">Contact us on <a target="_blank" href="http://research@aercafrica.org">research@aercafrica.org</a></p>
	</div>
</div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>
	
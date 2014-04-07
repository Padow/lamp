<!DOCTYPE html>
<html>
<head>
	<title>LAMPSERVER</title>
	<meta charset="UTF-8">
	<meta name="author" content="Padow">
	<link rel="icon" type="image/x-icon" href="lamp_files/images/favicon.png">
	<!-- Bootstrap -->
    <link href="lamp_files/css/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="lamp_files/css/index.css">
</head>
<body>
<div id="wrapper">
<div id="content">
<?php 
	$config = __DIR__."/lamp_files/config.ini";
	if($ini_array = parse_ini_file($config)){
		foreach ($ini_array as $key => $value) {
			if(strtoupper($key) == PHPMYADMINFOLDERNAME){
				if(!opendir($value)){
					echo '<div class="alert alert-danger"><strong>Warning!</strong> phpMyAdmin directory isn\'t valid, please watch "'.$config.'".</div>';
					define("PHPMYADMIN", null);
				}else{
					define("PHPMYADMIN", $value);
				}		
			}
		}
	}else{
		echo '<div class="alert alert-danger"><strong>Warning!</strong> Missing "lamp_files/config.ini"</div>';
		define("PHPMYADMIN", null);
	}

	function apache_version(){
		$apacheversion = apache_get_version();
		$vers = explode("/", $apacheversion);
		return $vers[1];
	}
 	$apache_version = apache_version();
 	$php_version = phpversion();
 	
	$loaded_extensions = get_loaded_extensions();
	function find_SQL_Version() {
	   $output = shell_exec('mysql -V');
	   preg_match('@[0-9]+\.[0-9]+\.[0-9]+@', $output, $version);
	   return $version[0];
	}
	$SQL_version = find_SQL_Version();


?>
<div class="container">
<div class="col">
	<!-- <img src="lamp_files/images/logo.jpg" class="img-responsive" alt="Responsive image"> -->
	<img src="lamp_files/images/logo.png" class="img-responsive" alt="Responsive image">
	<hr>
	<div class="col">
		<h3>Config server</h3>
		<ul><strong>Apache version : </strong><?= $apache_version ?></ul>
		<ul><strong>PHP version : </strong><?= $php_version ?></ul>
		<ul><strong>MySQL version : </strong><?= $SQL_version ?></ul>
		<ul><strong>Loaded extensions : </strong>

		<div class="table-responsive">
		<div class="col">
		<table class="table table-condensed">
		<tr>
		<?php 
		$cpt = 1;
		foreach ($loaded_extensions as $extension){
			if($cpt > 8){
				echo '</tr><tr>';
				$cpt = 1;
			}
			echo '<td class="noborder col-md-1"><span class="glyphicon glyphicon-cog"></span> '.$extension.'</td>'; 
			$cpt++;
		}
		?>
		</tr>

		</table>
		</div>
		</div>
		</ul>	
	</div>
	<div class="col">
		<h3>Tools</h3>
		<ul><a href="<?= PHPMYADMIN ?>" class="btn-link"><span class="glyphicon glyphicon-wrench"></span> phpMyAdmin</a></ul>
		<ul><a href="lamp_files/phpinfo.php" class="btn-link"><span class="glyphicon glyphicon-wrench"></span> phpinfo()</a></ul>	
	</div>
	<div class="col">
		<h3>Projects</h3>		
		<?php 
			$projectsListIgnore = array ('.','..','lamp_files', PHPMYADMIN);
			$handle=opendir(".");
			$projectContents = '';
			while ($file = readdir($handle)) 
			{
				if (is_dir($file) && !in_array($file,$projectsListIgnore)) 
				{		
					echo '<ul><a href="'.$file.'"><span class="glyphicon glyphicon-folder-open link">&nbsp;</span>'.$file.'</a></ul>';
				}
			}
			closedir($handle);
			

		 ?>
	</div>
</div>
</div>
</div>
  <div class="footer">
  <div class="container">
  <hr>
    <div class="col-md-12">
      <div class="col-md-8">
        <a href="https://github.com/Padow/lamp">Github</a>
      </div>
      <div class="col-md-4 pull-right">
        <p class="muted pull-right">© 2014 Padow. All rights reserved</p>
      </div>
    </div>
  </div>
  </div>
<script type="text/javascript" src="lamp_files/css/bootstrap/js/bootstrap.min.js"></script>
</div>
</body>
</html>
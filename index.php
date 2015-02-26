<!DOCTYPE html>
<html>
<head>
	<title>LAMPSERVER</title>
	<meta charset="UTF-8">
	<meta name="author" content="Padow">
	<link rel="icon" type="image/x-icon" href="lamp_files/images/favicon.ico">
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
	
	function apache_version(){
		$apacheversion = apache_get_version();
		$vers = explode("/", $apacheversion);
		return $vers[1];
	}
	if(apache_version())
 		$apache_version = apache_version();

 	$php_version = phpversion();
 	
	$loaded_extensions = get_loaded_extensions();
	$loaded_modules = apache_get_modules();
	function find_SQL_Version() {
	   $output = shell_exec('mysql -V');
	   preg_match('@[0-9]+\.[0-9]+\.[0-9]+@', $output, $version);
	   return $version[0];
	}
	$SQL_version = find_SQL_Version();


?>
<div class="container">
<div class="col-md-12">
	<?php if(apache_version()){?>
		<img src="lamp_files/images/logo.png" class="img-responsive" alt="Responsive image">
	<?php }else{ ?>
		<img src="lamp_files/images/lnamp.png" class="img-responsive" alt="Responsive image">
	<?php } ?>
	<hr>
	<div class="col-md-12">
		<h3>Config server</h3>
		<?php if(apache_version()){?>
		<ul><strong>Apache version : </strong><?= $apache_version ?></ul><?php } ?>
		<ul><strong>PHP version : </strong><?= $php_version ?></ul>
		<ul><strong>MySQL version : </strong><?= $SQL_version ?></ul>
		<div class="tt">
		 <?php 
		foreach ($loaded_modules as $module){
			echo '<div class="module"><span class="glyphicon glyphicon-cog"></span> '.$module.'</div>'; 
		}
		?></div>
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		  <div class="panel panel-default">
		    <div class="panel-heading" role="tab" id="headingOne">
		      <h4 class="panel-title">
		        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
		          Loaded extentions
		        </a>
		      </h4>
		    </div>
		    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
		      <div class="panel-body">
		        <?php 
				foreach ($loaded_extensions as $extension){
					echo '<div class="extention"><span class="glyphicon glyphicon-cog"></span> '.$extension.'</div>'; 
				}
				?>
		      </div>
		    </div>
		  </div>
		  <div class="panel panel-default">
		    <div class="panel-heading" role="tab" id="headingTwo">
		      <h4 class="panel-title">
		        <a class="collapsed" id="target" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
		          Loaded modules
		        </a>
		      </h4>
		    </div>
		    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
		      <div class="panel-body">
		        <?php 
				foreach ($loaded_modules as $module){
					echo '<div class="module"><span class="glyphicon glyphicon-cog"></span> '.$module.'</div>'; 
				}
				?>
		      </div>
		    </div>
		  </div>
		</div>
	</div>
	<div class="col-md-12">
		<h3>Tools</h3>
		<?php 
			$projectsListIgnore = array ('.','..','lamp_files');
			$Jconfig = __DIR__."/lamp_files/config.json";
			$dbcli = json_decode(file_get_contents($Jconfig));
			foreach ($dbcli->{'dbclient'} as $key => $value) {
				array_push($projectsListIgnore, $value->{'dataBaseClientLocation'});
				echo '<ul><a href="'.$value->{'dataBaseClientLocation'}.'" class="btn-link"><span class="glyphicon glyphicon-wrench"></span> '.$value->{'dataBaseClientName'}.'</a></ul>';
			}

		?>
		
		<ul><a href="lamp_files/phpinfo.php" class="btn-link"><span class="glyphicon glyphicon-wrench"></span> phpinfo()</a></ul>	
	</div>
	<div class="col-md-12">
		<h3>Projects</h3>		
		<?php 
			
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
<script type="text/javascript" src="lamp_files/jquery.js"></script>
<script type="text/javascript" src="lamp_files/css/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript">
var min_width = 1;
$('.extention').each(function(){
        var this_width = $(this).width();
        if (this_width > min_width) min_width = this_width;
});
$('.extention').width(min_width+10);



$( "#target" ).click(function() {
setTimeout(
  function() 
  {
  	var min_width_module = 1;
$('.module').each(function(){
        var this_width = $(this).width();
        if (this_width > min_width_module) min_width_module = this_width;
});
$('.module').width(min_width_module+10);
  }, 10);
});
</script>
</div>
</body>
</html>
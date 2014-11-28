<!DOCTYPE html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="<?php echo $WEBROOT; ?>img/honeypy.png">
<title>HoneyDB</title>

<!-- Bootstrap -->
<link href="<?php echo $WEBROOT; ?>vendor/twitter/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="<?php echo $WEBROOT; ?>vendor/twitter/bootstrap/examples/starter-template/starter-template.css" rel="stylesheet">

<link href="<?php echo $WEBROOT; ?>lib/jplot/jquery.jqplot.min.css" rel="stylesheet">
<link href="<?php echo $WEBROOT; ?>honeydb.css" rel="stylesheet">

<script src="<?php echo $WEBROOT; ?>vendor/frameworks/jquery/jquery.js"></script>
<script src="<?php echo $WEBROOT; ?>vendor/twitter/bootstrap/dist/js/bootstrap.min.js"></script>

<!--[if lt IE 9]>
	<script language="javascript" type="text/javascript" src="<?php echo $WEBROOT; ?>lib/jplot/excanvas.min.js"></script>
<![endif]-->

<script type="text/javascript" src="<?php echo $WEBROOT; ?>lib/jplot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="<?php echo $WEBROOT; ?>lib/jplot/plugins/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo $WEBROOT; ?>lib/jplot/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo $WEBROOT; ?>lib/jplot/plugins/jqplot.highlighter.min.js"></script>
<script type="text/javascript" src="<?php echo $WEBROOT; ?>lib/jplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo $WEBROOT; ?>lib/jplot/plugins/jqplot.pointLabels.min.js"></script>

<script type="text/javascript" src="<?php echo $WEBROOT; ?>honeydb.js"></script>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
<script language="javascript">
$(document).ready(function() {
});
</script>
</head>

<body>

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo $WEBROOT; ?>">HoneyDB</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?php echo $WEBROOT; ?>view-ip">Hosts</a></li>
            <li><a href="<?php echo $WEBROOT; ?>view-service">Services</a></li>
            <li><a href="<?php echo $WEBROOT; ?>about">About</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
</div>

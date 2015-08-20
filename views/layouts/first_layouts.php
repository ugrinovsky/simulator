<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Business Simulator</title>
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="/css/morris.css">
	<link rel="stylesheet" type="text/css" href="/css/main.css">

	<script type="text/javascript" src="/js/jquery.js"></script>
	<script type="text/javascript" src="/js/jquery-ui.js"></script>
	<script type="text/javascript" src="/js/jquery.cookie.js"></script>
	<script type="text/javascript" src="/js/bootstrap.js"></script>

	<script src="/js/morris/raphael.min.js"></script>
	<script src="/js/morris/morris.min.js"></script>
	<script src="/js/morris/morris-data.js"></script>

	<script src="/js/flot/jquery.flot.js"></script>
	<script src="/js/flot/jquery.flot.tooltip.min.js"></script>
	<script src="/js/flot/jquery.flot.resize.js"></script>
	<script src="/js/flot/jquery.flot.pie.js"></script>

	<meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0">

	<script type="text/javascript" src="/js/custom.js"></script>
</head>
<body>
	<div class="container" id="wrapper">
		<div class="row">
			<?php
				include($contentPage);
			?>	
		</div>
	</div>
</body>
</html>
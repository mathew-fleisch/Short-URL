<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Short URL</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<div id="container">
	<h1>Short URL</h1>
	<div id="errors"></div>
	<div id="form-container">
		<input type="text" class="form-control" id="long-url" value="https://github.com/zenorocha/clipboard.js.git" />
		<button class="btn btn-default" id="shrink">shrink</button>
		<br class="clear" />
	</div>
	<br />

	<div id="output-container">
		<label id="short-url-label" for="short-url">Copy to clipboard</label><br />
		<input class="form-control" id="short-url" value="" readonly>
		<button class="btn btn-default" id="copy-btn" data-clipboard-target="#short-url">
		    <img class="invert-svg" width="13" src="assets/clippy.svg" alt="Copy to clipboard">
		</button>
		<br class="clear" />
	</div>
</div>


    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/clipboard.min.js"></script>
    <script src="js/functions.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
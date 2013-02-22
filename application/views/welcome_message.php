<!DOCTYPE html>
<html lang="en" class=<?php echo '"'.implode(' ', $html_classes).'"'; ?>>
<head>
	<meta charset="utf-8">
	<title>Welcome to Kindling</title>
	<?php foreach($css_files as $key => $value) { echo $value; } ?>
	<?php foreach($js_files as $key => $value) { echo $value; } ?>
</head>
<body>
<header class="clearfix">
	<div class="container clearfix">
		<div id="logo" class="one-third column"><h1><?php echo $title;?></h1></div>
		<nav class="two-thirds column">
			<a href="#">Home</a>
			<a href="#">About</a>
			<a href="#">Login</a>
			<a href="#">Register</a>
		</nav>
	</div>
</header>

<div id="main" class="container">
	<article class="column">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	</article>
</div>

<footer class="clearfix">
	<div class="container">
		<h5>Kindling for code igniter</h5>
	</div>
</footer>
	
</div>

</body>
</html>
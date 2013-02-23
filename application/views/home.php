<!DOCTYPE html>
<html lang="en" class=<?php echo $html_classes; ?>>
<head>
	<title><?php echo $title; ?></title>
	<?php echo $meta_tags ?>
	<?php echo $css_files; ?>
	<?php echo $js_files; ?>
</head>
<body>
<header>
	<div class="container_12">
		<div id="logo" class="grid_4"><h1>Page Title</h1></div>
		<nav class="grid_4">
			<a href="#">Home</a>
			<a href="#">About</a>
			<a href="#">Login</a>
			<a href="#">Register</a>
		</nav>
	</div>
</header>

<div id="main" class="container_12">
	<article class="grid_7 suffix_1 alpha">
		<h2>Welcome to MyLandingPage!</h2>
		<p>
			Welcome to MylandingPage! A website built as a porfolio piece by harris Miller. Use the above menu to navigate around.
		</p>
		<h3>What it does:</h3>
		<p>
			MyLandingPage saves data from a logged in user and randemly generates a page displaying that data.\n This website is built in on an Ajax structure displayed info will not navigate you away from this page.\m The only exception to thisis the "Output" page which is meant to be a stand-alone page.
		</p>
	</article>
	<aside class="grid_4 omega">
		<h3>Aside</h3>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		</p>
	</aside>
</div>

<?php var_dump($this->data); ?>

<footer>
	<div class="container_12">
		<div class="grid_2 prefix_5">
			<h5>Kindling for code igniter</h5>
		</div>
	</div>
</footer>
	
</div>

</body>
</html>
<body>
	<header>
		<div class="container_12">
			<div id="logo" class="grid_4"><h1>Page Title</h1></div>
			<nav class="grid_6">
				<a href="#">Home</a>
				<a href="#">About</a>
				<a href="#">Login</a>
				<a href="#">Register</a>
				<time><?php //echo $datetime; ?></time>
			</nav>
		</div>
	</header>
	<div id="main" class="container_12">
		<div class="grid_7">
			<?php echo $content; ?>
		</div>
		<?php echo $modules['aside']; ?>
		<?php //var_dump(is_object($this->config)); ?>
	</div>
	<footer>
		<div class="container_12">
			<div class="grid_2 prefix_5">
				<h5>Kindling for code igniter</h5>
			</div>
		</div>
	</footer>
</body>
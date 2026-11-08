<!doctype html>
<html>
<head>
	<title>Tree</title>
	
	<!-- Bootstrap - Part 1 -->
	<link rel="stylesheet" href="<?= base_url('assets/modules/bootstrap/bootstrap.min.css') ?>">
	
	<!-- jQuery UI (Flick) - Part 1 -->
	<link rel="stylesheet" href="<?= base_url('assets/modules/jquery-ui/themes/flick/jquery-ui.min.css') ?>">
	
</head>
<body>
	
	<!-- Render the header-->
	<nav class="navbar navbar-expand-lg bg-body-tertiary">
		<div class="container-fluid">
			<a class="navbar-brand" href="#">Tree</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link" aria-current="page" href="#">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" aria-current="page" href="/files">Files</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
		
	<!-- Render the page-->
	<div class="container">
		<?php 
			if(!empty($title)) {
				echo '<h2 class="my-2">'.esc($title).'</h2>';
			}
		?>
		<?= $this->renderSection('content') ?>
		
		<!-- Show any errors -->
		<?php 
			if(!empty($errors)):
				foreach ($errors as $error): 
				?>
					<li><pre><?= print_r($error, true) ?></pre></li>
				<?php 
				endforeach;
			endif;
		?>
		
		<!-- Modal -->
		<?php
			# modal
			# modalTitle
			# modalBody
			# modalSave
		?>
		<div class="modal" id="modal" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modalTitle">Modal title</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" id="modalBody">
						<p>Modal body text goes here.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="modalSave">Save changes</button>
					</div>
				</div>
			</div>
		</div>
		
		<!-- jQuery dialog -->
		<div id="dialog-confirm" class="mt-3"><div id="dialog-confirm-body"></div></div>
	</div>
	
	<!-- Render the footer-->
	<nav class="navbar fixed-bottom bg-primary" data-bs-theme="dark">
		<div class="container-fluid">
			<a class="navbar-brand" href="#">
				Tree <em>&copy; <?= date("Y"); ?></em>
			</a>
		</div>
	</nav>
	
	<!-- jQuery -->
	<!-- <script src="https://code.jquery.com/jquery-4.0.0.min.js" integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao=" crossorigin="anonymous"></script> -->
	<script src="<?= base_url('assets/modules/jquery/jquery.min.js') ?>"></script>
	
	<!-- jQuery UI Part 2 -->
	<script src="<?= base_url('assets/modules/jquery-ui/jquery-ui.min.js') ?>"></script>
	
	<!-- Bootstrap Part 2 -->
	<script src="<?= base_url('assets/modules/bootstrap/bootstrap.bundle.min.js') ?>"></script>
	
	<!-- Common JS -->
	<script src="<?= base_url('assets/js/common.js') ?>"></script>
	
	<!-- View scripts -->
	<?= $this->renderSection('scripts') ?>
	
</body>
</html>
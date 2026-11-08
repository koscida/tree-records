<?php
/**
 * File Home Page
 */


// Use default layout
$this->extend('layouts/default');

// Begin Content
$this->section('content');

?>

	<h3>Your file was successfully uploaded!</h3>

	<ul>
		<li>name: <?= esc($file->getBasename()) ?></li>
		<li>size: <?= esc($file->getSizeByUnit('kb')) ?> KB</li>
		<li>extension: <?= esc($file->guessExtension()) ?></li>
	</ul>

	<p><?= anchor('upload', 'Upload Another File!') ?></p>

<?php

// End Content
$this->endSection();

?>
<script>

</script>
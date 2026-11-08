<?php
/**
 * New file Page
 */

helper('form');

// Use default layout
$this->extend('layouts/default');

// Begin Content
$this->section('content');

?>
	<?= form_open_multipart('files/upload') ?>
		
		<div class="input-group mb-3">
			<input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv">
			<button class="btn btn-outline-secondary" type="submit" id="upload">Upload</button>
		</div>
	</form>
	
	<?= WRITEPATH . 'uploads/' ?>
	
<?php

// End Content
$this->endSection();

?>
<script>

</script>
<?php
/**
 * Filse Home Page
 */

// Use default layout
$this->extend('layouts/default');

// Begin Content
$this->section('content');
	
	// Check for any files
	if(!empty($files)) {
		?>
		<table class="table border">
			<tr>
				<th>ID</th>
				<th>File Name</th>
				<th>File Path</th>
				<th>Original Name</th>
				<th>Created At</th>
				<th>Updated At</th>
				<th></th>
			</tr>
			<?php foreach ($files as $file) { 
				$fileId = $file['id'];
				
				// try to get the file
				$deleted = false;
				if(file_exists($file['filePath'])) {
					$deleted = true;
				}
				
				?>
				<tr id="file-row-<?= $fileId ?>">
					<td><?= esc($fileId) ?></td>
					<td><?= esc($file['filename']) ?></td>
					<td><?= esc($file['filepath']) ?></td>
					<td><?= esc($file['originalName']) ?></td>
					<td><?= esc($file['createdAt']) ?></td>
					<td><?= esc($file['updatedAt']) ?></td>
					<td>
						<div class="btn-group btn-group-sm" role="group" aria-label="Basic mixed styles example">
							<?php if ($deleted): ?>
								<button type="button" class="btn btn-danger deleteFile" data-id="<?= $fileId ?>">Delete</button>
							<?php else: ?>
								<a href="<?= base_url('files/'.$fileId) ?>" class="btn btn-primary" data-id="<?= $fileId ?>">Open</a>
							<?php endif; ?>
						</div>
					</td>
				</tr>
			<?php } ?>
		</table>
		<meta name="csrf-token" content="<?= csrf_hash() ?>">
		<?php
	} else { 
		?>
			<p>No files</p>
		<?php
	}
	?>
	<a href="/files/new" class="btn btn-primary">Upload file</a>
	
	<div id="ajax-message"></div>
	
	<?php

// End Content
$this->endSection();


// Begin Scripts
$this->section('scripts');
?>
<script>
	$(document).ready(function() {
	
		$(".deleteFile" ).on("click", function() {
			// Get button meta
			let button = $(this);
        	let id = button.data('id');
		
			// Confirm 
			confirmDialog({
				title: "Confirm deletion?",
				body: "Do you want to delete this file?"
			}, function() {
				submitDelete(button, id)
			})
		})
		
		function submitDelete(button, id) {
			console.log("confirmed")
			
			// Disable button
			button.prop('disabled', true).text('Deleting...');
			
			// Submit delete via ajax
			$.ajax({
				url: '<?= base_url('files/delete/') ?>' + id,
				type: 'POST',
				dataType: 'json',
				data: {
					'<?= csrf_token() ?>': $('meta[name="csrf-token"]').attr('content')
				},
				success: function (response) {
					if (response.success) {
						// Remove the row from the table
						$('#file-row-' + id).fadeOut(400, function() {
							$(this).remove();
						});

						$('#ajax-message')
							.html('<div class="alert alert-success">' +
								response.message +
								'</div>');
								
						// $.alert('Deleted');
					} else {
					
						button.prop('disabled', false).text('Delete');

						$('#ajax-message')
							.html('<div class="alert alert-danger">' +
								response.message +
								'</div>');
					}
				},
				error: function(xhr) {

					button.prop('disabled', false).text('Delete');

					let message = 'An error occurred while deleting the file.';

					if (xhr.responseJSON && xhr.responseJSON.message) {
						message = xhr.responseJSON.message;
					}

					$('#ajax-message')
						.html('<div class="alert alert-danger">' +
							message +
							'</div>');
				}
			});
		}
	});
</script>

<?php
// End Content
$this->endSection();
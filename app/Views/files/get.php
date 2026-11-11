<?php
/**
 * File (ID) Home Page
 */

// Use default layout
$this->extend('layouts/default');

// Begin Content
$this->section('content');
?>

<h3>Uploaded file</h3>

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
	<tr id="file-row-<?= $file['id'] ?>">
		<td><?= esc($file['id']) ?></td>
		<td><?= esc($file['filename']) ?></td>
		<td><?= esc($file['filepath']) ?></td>
		<td><?= esc($file['originalName']) ?></td>
		<td><?= esc($file['createdAt']) ?></td>
		<td><?= esc($file['updatedAt']) ?></td>
	</tr>
</table>



<h3>Mapping</h3>
<?php
// Open CSV file
$fullFilePath = WRITEPATH . $file['filepath'];
$handle = fopen($fullFilePath, 'r');

$rows = [];
$maxRows = 50;
$totalColumns = 0;

if ($handle !== false) {
	// Read all rows
	while (($row = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {

        $rows[] = $row;

        $totalColumns = max($totalColumns, count($row));

        if (count($rows) >= $maxRows) {
            break;
        }
    }

    fclose($handle);
}
?>
<div class="border" style="overflow:scroll;height:400px;">
<?php if ($handle === false): ?>

	<div class="empty">
		Unable to open CSV file.
	</div>

<?php elseif (empty($rows)): ?>

	<div class="empty">
		CSV file is empty.
	</div>

<?php else: ?>
	<div class="table-wrapper">

		<table class="table">
			<thead>
				<tr>
					<th class="row-number">#</th>

					<?php for ($i = 1; $i <= $totalColumns; $i++): ?>
						<th><?= $i ?></th>
					<?php endfor; ?>

				</tr>
			</thead>
			<tbody>
				<?php foreach ($rows as $rowIndex => $row): ?>
					<tr>
						<td class="row-number">
							<?= $rowIndex + 1 ?>
						</td>
						<?php for ($i = 0; $i < $totalColumns; $i++): ?>
							<td>
								<?= esc($row[$i] ?? '') ?>
							</td>
						<?php endfor; ?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

	</div>
	
	<p class="info">
		Showing <?= count($rows) ?> preview rows.
		across <?= $totalColumns ?> columns.

		<?php if (count($rows) >= $maxRows): ?>
			Preview limited to the first <?= $maxRows ?> rows.
		<?php endif; ?>
	</p>

<?php endif; ?>
</div>
		
		

<h3>File Rows</h3>

<?php
// End Content
$this->endSection();


// Begin Scripts
$this->section('scripts');
// End Content
$this->endSection();
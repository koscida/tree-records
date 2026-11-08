<?php

namespace App\Controllers;

use CodeIgniter\Files\File;
use App\Models\FilesModel;
use App\Models\FileRowsModel;

class Files extends BaseController
{
    public function index(): string
    {
		$model = model(FilesModel::class);
		
		$data = [
			'title'		=> "Files",
			'files'		=> $model->getFiles(),
		];
		
        return view('files/index', $data);
    }
	
	public function new(): string 
	{
		$data = [
			'title'		=> "Upload File",
		];
		
		return view('files/new', $data);
	}
	
	public function upload()
    {
		$data = [];
		
		$file = $this->request->getFile('csv_file');
		
		// Validate submission
		$validationRule = [
            'csv_file' => [
				'label'  => 'CSV File',
				'rules'  => 'ext_in[csv_file,csv]|mime_in[csv_file,text/csv]',
				'errors' => [
					'ext_in' => 'wrong extension',
					'mime_in' => 'wrong mime'
				],
			],
        ];
        if (! $this->validateData([], $validationRule)) {
            $data['errors'][] = $this->validator->getErrors();
			$data['errors'][] = $file;

            return view('/files/new', $data);
        }
		
		$filename = $file->getFilename();
		$originalName = $file->getClientName();

        if (! $file->hasMoved()) {
            $filepath = WRITEPATH . 'uploads/' . $file->store("records", $originalName);
			
			$fileModel = new FilesModel();
			
			// Add a new file
			$fileData = [
				'filePath' => $filepath,
				'fileName' => $filename,
				'originalName' => $originalName,
				'headerRows' => 1,
			];
			$id = $fileModel->insert($fileData);
			
			$data = [
				'file' => new File($filepath),
			];

            return redirect()->to('fileRows/bulkNew/'.$id);
        }

        $data = [
			'errors' => 'The file has already been moved.'
		];

        return view('/files/new', $data);
	}
	
	// Ajax
	public function delete($id) {
		
		// Get file by id
		$fileModel = model(FilesModel::class);
        $file = $fileModel->getFile($id);
		
		// Check if no file
		if ($file === null) {
			return $this->response
				->setStatusCode(404)
				->setJSON([
					'success' => false,
					'message' => 'File not found.'
				]);
        }
		
		// Soft delete
		if ($fileModel->delete($id)) {
			return $this->response->setJSON([
				'success' => true,
				'message' => 'File successfully deleted.'
			]);
		}

		return $this->response
			->setStatusCode(500)
			->setJSON([
				'success' => false,
				'message' => 'Unable to delete file.'
			]);
	}
	
	
	
	public function upload_old1()
    {
        $file = $this->request->getFile('csv_file');
		
		log_message('debug', "");

        // Validate uploaded file
        if (!$file) {
            return redirect()->back()
                ->with('error', 'Please upload a CSV file.');
        }
		if (!$file->isValid()) {
            return redirect()->back()
                ->with('error', 'Please upload a valid CSV file.');
        }
        if ($file->getExtension() !== 'csv') {
            return redirect()->back()
                ->with('error', 'Only CSV files are allowed.');
        }

        // Open CSV file
        $handle = fopen($file->getTempName(), 'r');

        if (!$handle) {
            return redirect()->back()
                ->with('error', 'Unable to read CSV file.');
        }

        $fileModel = new FilesModel();
		$fileRowModel = new FileRowsModel();
		
		$filename = $file->getFilename();
		
		// Add a new file
		$fileData = [
			'filePath' => $file->getTempName(),
			'fileName' => $filename,
			'headerRows' => 1,
		];
		$fileModel->insert($fileData);
		
		$file->move(WRITEPATH . 'uploads', $filename);

        // // Skip header row
        // fgetcsv($handle);

        // $imported = 0;

        // // Read each CSV row
        // while (($row = fgetcsv($handle)) !== false) {

        //     if (count($row) < 4) {
        //         continue;
        //     }

        //     $rowData = [
        //         'first_name' => trim($row[0]),
        //         'last_name'  => trim($row[1]),
        //         'email'      => trim($row[2]),
        //         'phone'      => trim($row[3])
        //     ];

        //     $fileRowModel->insert($rowData);

        //     $imported++;
        // }

        fclose($handle);

        return redirect()->to('/files/new')
            ->with('success', "file imported successfully.");
    }
}
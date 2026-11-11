<?php

namespace App\Controllers;

use CodeIgniter\Files\File;
use App\Models\FilesModel;
use App\Models\FileRowsModel;

class Files extends BaseController
{
    public function index(): string
    {
		$fileModel = model(FilesModel::class);
		
		// Build page data
		$data = [
			'title'		=> "Files",
			'files'		=> $fileModel->getFiles(),
		];
		
        return view('files/index', $data);
    }
	
	public function get($id) {
		$fileModel = model(FilesModel::class);
		$fileRowsModel = model(FileRowsModel::class);
		
		// Get one file
		$file = $fileModel->getFile($id);
		
		// Check if file exists
		if ($file === null) {
			// Redirect back to files list
			return redirect()->to('files/');
        }
		
		// Extract data
		$id = $file['id'];
		
		// Get any rows
		$fileRows = $fileRowsModel->getRows(["fileId" => $id]);
		
		// Build page data
		$data = [
			'title'		=> "File (ID ".$id.")",
			'file'		=> $file,
			'fileRows'	=> $fileRows
		];
		return view('files/get', $data);
	}
	
	public function new(): string 
	{
		// Build page data
		$data = [
			'title'		=> "Upload File",
		];
		
		return view('files/new', $data);
	}
	
	public function upload()
    {
		// Build page data
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

			// Error, return the same view but with errors
            return view('/files/new', $data);
        }
		
		$filename = $file->getFilename();
		$originalName = $file->getClientName();

        if (! $file->hasMoved()) {
            $filepath = 'uploads/' . $file->store("records", $originalName);
			$writepath = WRITEPATH . $filepath;
			
			$fileModel = new FilesModel();
			
			// Add a new file
			$fileData = [
				'filepath' => $filepath,
				'filename' => $filename,
				'originalName' => $originalName,
				'headerRows' => 1,
			];
			$id = $fileModel->insert($fileData);
			
			$data = [
				'file' => new File($writepath),
			];

			// Success, redirect to the file page
            return redirect()->to('files/'.$id);
        }

        $data = [
			'errors' => 'The file has already been moved.'
		];

		// Error, return the same view but with errors
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
}
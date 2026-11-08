<?php

namespace App\Controllers;

use CodeIgniter\Files\File;
use App\Models\FilesModel;
use App\Models\FileRowsModel;

class FileRows extends BaseController
{
	public function index() {}
	
    public function bulkNew(?string $id = null)
    {
		if($id === null) {
			return redirect()->to('files/new/');
		}
		
		$fileModel = model(FilesModel::class);
		
		$data = [
			'title'		=> "Files",
			'file'		=> $fileModel->getFile($id),
		];
		
        return view('fileRows/bulkNew', $data);
    }
	
}
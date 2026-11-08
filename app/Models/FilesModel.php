<?php

namespace App\Models;

use CodeIgniter\Model;

class FilesModel extends Model
{
    protected $table = 'files';
	
	protected $primaryKey = 'id';

    protected $allowedFields = [
        'fileName',
        'filePath',
		'originalName'
    ];

    protected $useTimestamps	= true;
	protected $dateFormat		= 'datetime';
    protected $createdField		= 'createdAt';
    protected $updatedField		= 'updatedAt';
	
	protected $useSoftDeletes	= true;
    protected $deletedField		= 'deletedAt';
	
	public function getFiles()
    {
		return $this->findAll();
	}
	
	public function getFile($fileId = false)
    {
		return $this->where(['id' => $fileId])->first();
	}
}
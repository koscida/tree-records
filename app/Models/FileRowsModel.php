<?php

namespace App\Models;

use CodeIgniter\Model;

class FileRowsModel extends Model
{
    protected $table = 'fileRows';
	
	protected $primaryKey = 'id';

    protected $allowedFields = [
        'fileId',
        'rowId',
        'data'
    ];

    protected $useTimestamps	= true;
	protected $dateFormat		= 'datetime';
    protected $createdField		= 'createdAt';
    protected $updatedField		= 'updatedAt';
	
	protected $useSoftDeletes	= true;
    protected $deletedField		= 'deletedAt';
	
	
	public function getRows($fileId = false)
    {
		if ($fileId === false) {
			return [];
		}
			
		return $this->where(['fileId' => $fileId]);
	}
}
<?php 
namespace App\Repositories;

use App\Models\RoomInventories;
use App\Repositories\Interfaces\RoomInventoriesRepositoryInterface;

class RoomInventoriesRepository extends BaseRepository implements RoomInventoriesRepositoryInterface{
	
	public function __construct(RoomInventories $model){
		$this->_model = $model;
	}
}
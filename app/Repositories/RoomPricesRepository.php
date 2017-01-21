<?php 
namespace App\Repositories;

use App\Models\RoomPrices;
use App\Repositories\Interfaces\RoomPricesRepositoryInterface;

class RoomPricesRepository extends BaseRepository implements RoomPricesRepositoryInterface{
	
	public function __construct(RoomPrices $model){
		$this->_model = $model;
	}
}
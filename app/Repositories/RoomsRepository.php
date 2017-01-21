<?php 
namespace App\Repositories;

use App\Models\Rooms;
use App\Repositories\Interfaces\RoomsRepositoryInterface;
use App\Repositories\RoomsRepository;

class RoomsRepository implements RoomsRepositoryInterface {
	protected $_model;

	public function __construct(Rooms $model){
		$this->_model = $model;
	}

	public function get_all_rooms(){
		return $this->_model->get();
	}

}
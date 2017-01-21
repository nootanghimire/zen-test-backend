<?php 
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Interfaces\BaseRepositoryInterface;

class BaseRepository implements BaseRepositoryInterface{
	protected $_model;

	public function __construct(Model $model){
		$this->_model = $model;
	}

	public function get_results($room_type, $date){
		if (is_array ($date) ) {
            $results = $this->_model->get()->whereIn('effective_date', $date);
        } else { 
            $results = $this->_model->get()->where('effective_date', $date);
        }

        if (is_numeric (current ($room_type) ) ) {
            $results = $results->whereIn('room_type_id', $room_type);
        }

        return $results;
	}

	public function get_results_range ($room_type, $date_start, $date_end) {
        $results = $this->_model->whereBetween('effective_date', [$date_start, $date_end])->get();
        
        if (is_numeric (current ($room_type) ) ) {
            $results = $results->whereIn('room_type_id', $room_type);
        }

        return $results;
    }
}
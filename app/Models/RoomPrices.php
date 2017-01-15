<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomPrices extends Model
{
     protected $table = 'room_prices';

    protected $primaryKey = 'id';

    protected $fillable = ['room_type_id', 'price', 'effective_date'];

    protected $filters = [];

    public function set_filter ($filter_label, $filter_value) {
    	$this->filters[$filter_label] = $filter_value;
    }

    public function get_all_filters () {
    	return $this->filters;
    }

    public function get_filter ($filter_label) {

    }

    public function get_all_results_json () {

    }

    public function get_filtered_results_json () {

    }

    public function save_json_to_database () {
    	
    }

}

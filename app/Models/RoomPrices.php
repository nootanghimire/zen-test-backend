<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomPrices extends Model
{
     protected $table = 'room_prices';

    protected $primaryKey = 'id';

    protected $fillable = ['room_type_id', 'price', 'effective_date'];

    public function get_results ($room_type, $date) {
        if (is_array ($date) ) {
            $results = $this->get()->whereIn('effective_date', $date);
        } else { 
            $results = $this->get()->where('effective_date', $date);
        }

        if (is_numeric (current ($room_type) ) ) {
            $results = $results->whereIn('room_type_id', $room_type);
        }

        return $results;
    }

    public function get_results_range ($room_type, $date_start, $date_end) {
        $results = $this->whereBetween('effective_date', [$date_start, $date_end])->get();
        
        if (is_numeric (current ($room_type) ) ) {
            $results = $results->whereIn('room_type_id', $room_type);
        }

        return $results;
    }

    public function createIfExists($params){
        
    }


}

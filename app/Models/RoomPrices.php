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
}

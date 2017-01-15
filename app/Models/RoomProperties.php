<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomProperties extends Model
{
    // Downside of not writing Repository Pattern
    // Used to reduce redundant functions in other models
    
    public function get_results ($room_type, $date) {
        if (is_array ($date) ) {
            $results = $this->get()->whereIn('effective_date', $date);
        } else { 
            $results = $this->get()->where('effective_date', $date);
        }
        
        if (is_numeric ($room_type) ) {
            $results = $results->where('room_type_id', $room_type);
        }

        return $results;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomPrices extends Model
{
     protected $table = 'room_prices';

    protected $primaryKey = 'id';

    protected $fillable = ['room_type_id', 'price', 'effective_date'];
}

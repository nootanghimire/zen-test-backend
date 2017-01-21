<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomInventories extends Model
{
    protected $table = 'room_inventories';

    protected $primaryKey = 'id';

    protected $fillable = ['room_type_id', 'num_available', 'effective_date'];

}



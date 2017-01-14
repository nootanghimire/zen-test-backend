<?php

use Illuminate\Database\Seeder;

class RoomInventoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $room_ids = DB::table('rooms')->pluck('id');
        foreach($room_ids as $room_id) {
        	DB::table('room_inventories')->insert([
        		'room_type_id' => $room_id,
        		'num_available' => 5,
        		'effective_date' => '2017-01-12'
        	]);
        }
    }
}

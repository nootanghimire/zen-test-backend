<?php

use Illuminate\Database\Seeder;

class RoomPricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $single_room_id = DB::table('rooms')->where('label', 'Single Room')->value('id');
        $double_room_id = DB::table('rooms')->where('label', 'Double Room')->value('id');
        DB::table('room_prices')->insert([
        	'room_type_id' => $single_room_id,
        	'price' => '5000IDR',
      		'effective_date' => '2017-01-12'
        ]);

        DB::table('room_prices')->insert([
        	'room_type_id' => $double_room_id,
        	'price' => '8000IDR',
      		'effective_date' => '2017-01-12'
        ]);
    }
}

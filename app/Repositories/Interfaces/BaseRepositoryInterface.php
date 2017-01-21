<?php 
namespace App\Repositories\Interfaces;


interface BaseRepositoryInterface{

	public function get_results($room_type, $date);
	public function get_results_range($room_type, $date_start, $date_end);

}

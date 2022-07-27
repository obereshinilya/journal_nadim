<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class MenuController extends Controller
{
   public function index_hour()
   {
       $new_log  = (new MainTableController)->create_log_record('Открыл часовые показатели');
       return view('time_params_hour');
   }
   public function index_sut()
   {
       $new_log  = (new MainTableController)->create_log_record('Открыл суточные показатели');
       return view('time_params_sut');
   }
   public function index_minut()
   {
       $new_log  = (new MainTableController)->create_log_record('Открыл показатели реального времени');
       return view('time_params_minut');
   }
   public function open_user_log()
   {
       $new_log  = (new MainTableController)->create_log_record('Открыл журнал действий оператора');
       return view('web.journal_user_log');
   }
   public function get_user_log()
   {
       $data = Log::orderbyDesc('id')->get();
       return $data;
   }


}

?>

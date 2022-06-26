<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GD_obj;

class MenuController extends Controller
{
   public function index_hour()
   {
       return view('time_params_hour');
   }
   public function index_sut()
   {
       return view('time_params_sut');
   }
}

?>

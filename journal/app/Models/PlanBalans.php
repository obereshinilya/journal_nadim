<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanBalans extends Model{
    protected $table='public.plan';
    public $timestamps = false;
    public $primaryKey = 'id';
    protected $fillable = [
        'id', 'month', 'plan_month',
    ];


}

?>

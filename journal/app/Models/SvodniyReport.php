<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SvodniyReport extends Model{
    protected $table='public.svodniy_report';
    public $timestamps = false;
    public $primaryKey = 'id';
    protected $fillable = [
        'p_yams', 'q_yams', 'p_yub', 'q_yub', 'config', 'timestamp'
    ];


}

?>

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableObj extends Model{
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

    public function getMinsParam($date_start)
    {
        for ($i=0; $i<=11; $i++){
            $min = 5*$i;
            $min_buff = 5*$i + 2;

            $arr[$i] = $this->hasOne('App\Models\Min_params' ,'hfrpok_id', 'hfrpok')
                ->whereBetween('timestamp', [date('Y-m-d H:i', strtotime($date_start.' +'. $min.' minutes')), date('Y-m-d H:i', strtotime($date_start.' +'. $min_buff .' minutes'))])
                ->select('val')->orderby('id')->first();
            if($arr[$i]){
                $arr[$i] = $arr[$i]->toArray();
            }
        }
        return $arr;
    }

    public function get_hour_param_at_day($hfrpok, $disp_day)
    {

    }

    public function getParentKeyName()
    {
        return 'parentId';
    }

    public function getLocalKeyName()
    {
        return 'id';
    }

    protected $table='app_info.test_table';
    public $timestamps = false;
    public $primaryKey = 'id';
    protected $fillable = [
        'hfrpok', 'namepar1', 'inout', 'shortname', 'level', 'parentId', 'guid_masdu_5min', 'guid_masdu_hours', 'guid_masdu_day',
        'tag_name', 'min_param', 'hour_param', 'sut_param', 'name_str'
    ];


    static function createTree(&$list, $parent){
        $tree = array();
        foreach ($parent as $k=>$l){
            if(isset($list[$l['id']])){
                $l['children'] = TableObj::createTree($list, $list[$l['id']]);
            }
            $tree[] = $l;
        }
        return $tree;
    }

    public static function getTree(){
        $data=TableObj::select('id', 'hfrpok',
        'namepar1', 'parentId', 'level')->where('inout', '=', '!')->orderBy('parentId')->orderBy('id')->get();

        foreach ($data as $row){
            $arr[]=array('id'=>$row->id,
                'hfrpok'=>$row->hfrpok,
                'namepar1'=>$row->namepar1,
                'parentId'=>$row->parentId,
                'level'=>$row->level);
        }

        $new = array();
        foreach ($arr as $a){
            $new[$a['parentId']][] = $a;
        }
        $tree = TableObj::createTree($new, array($data[0]));

        return $tree;
    }

    public static function getFieldsName(){
        $fields=TableObj::select('namepar1', 'id')->where('level', '=', '2')->get();
        return $fields;
    }

    public static function getObjectsName(){
        $objects=TableObj::select('namepar1', 'id')->where([['level', '=', '3'], ['inout', '=', '!']])->get();
        return $objects;
    }



}

?>

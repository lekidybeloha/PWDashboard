<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    //
    protected $table        = 'carts';
    protected $primaryKey   = 'id';
    protected $fillable     = ['title', 'color', 'position', 'archive'];

    public static function getByIdDashboard($id)
    {
        $res = self::where('id_dashboard', '=', $id)->where('archive', '=', 0)->orderBy('position')->get();

        return $res;
    }

    public static function create($verb)
    {
        $count = self::where('id_dashboard', '=', $verb->input('id_dashboard'))->count();
        $data['id_dashboard']   = $verb->input('id_dashboard');
        $data['title']          = $verb->input('title');
        $data['color']          = 'none';
        $data['position']       = $count + 1;
        $data['archive']        = 0;
        self::insert($data);
    }

    public static function updateData($verb)
    {
        $data   = [];
        $update = $verb->all();
        foreach($update as $k=>$one)
        {
            if($k != 'id'){
                $data[$k] = $one;
            }

            if($k == 'title'){
                $data[$k] = urlencode($one);
            }
        }

        $res = self::where('id', '=', $update['id'])->update($data);
        if($res)
        {
            return ['success' => TRUE];
        }
        else
        {
            return ['success' => FALSE];
        }

    }

    public static function move($id_cart, $new_value)
    {
        $lastValue  = self::find($id_cart);
        $temp       = self::where('position', '=', $new_value)->first();
        self::find($id_cart)->update(['position' => $new_value]);
        self::find($temp->id)->update(['position' => $lastValue->id]);
    }

    public static function archive($id)
    {
        self::find($id)->update(['archive' => 1]);
    }
}

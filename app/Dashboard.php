<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Dashboard extends Model
{
    //
    protected $table        = 'dashboard';
    protected $primaryKey   = 'id';
    static $table_child     = 'dashboard_users';

    public static function one($id)
    {
        return self::find($id);
    }

    public static function getAllByUser($id)
    {
        $res = self::where(['id_user' => $id])->get();

        return $res;
    }

    public static function create($verb)
    {
        $data['name']           = $verb->input('name');
        $data['id_user']        = $verb->input('user');
        $data['privacy']        = $verb->input('privacy');
        $data['color']          = $verb->input('color');
        $data['favoris']        = 0;
        $data['created_at']     = @date('Y-m-d H:i:s');
        $data['updated_at']     = @date('Y-m-d H:i:s');
        self::insert($data);
    }

    public static function updateFavoris($verb)
    {
        $res = self::where(['id' => $verb->input('id_dashboard')])->update(['favoris' => $verb->input('fav')]);

        if($res)
        {
            return ['success'   =>  TRUE];
        }
        else
        {
            return ['success'   =>  FALSE];
        }
    }

    public static function getCooperativeTable($id)
    {
        $data   = [];
        $res    = DB::table(self::$table_child)->where('id_user', '=', $id)->get();
        if(!empty($res))
        {
            foreach ($res as $one)
            {
                $data[] = self::find($one->id_dashboard);
            }
        }

        return $data;
    }

    public static function getUserInDashboard($id)
    {
        $data   = [];
        $res    = DB::table(self::$table_child)->where('id_dashboard','=',$id)->get();
        if(!empty($res))
        {
            foreach($res as $one)
            {
                $data[] = User::find($one->id_user);
            }
        }

        return $data;
    }

    public static function addUserToDashboard($id_user, $id_dashboard)
    {
        $data['id_dashboard']   = $id_dashboard;
        $data['id_user']        = $id_user;
        $data['created_at']     = @date('Y-m-d H:i:s');
        $data['updated_at']     = @date('Y-m-d H:i:s');
        $res                    = DB::table(self::$table_child)->insert($data);
        if($res)
        {
            return ['success' => TRUE];
        }
    }
}

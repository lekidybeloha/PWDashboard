<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskFiles extends Model
{
    //
    protected $table        = 'dashboard_task_files';
    protected $primaryKey   = 'id';
    protected $fillable     = ['id_dashboard_task', 'link'];

    public static function storeFiles($id_cart, $path)
    {
        $data['id_dashboard_task']  = $id_cart;
        $data['link']               = $path;
        $data['dropped']            = 0;
        $data['created_at']         = @date('Y-m-d H:i:s');
        $data['updated_at']         = @date('Y-m-d H:i:s');
        self::insert($data);
    }

    public static function getFiles($id_cart)
    {
        return self::where('id_dashboard_task', '=', $id_cart)->get();
    }
}

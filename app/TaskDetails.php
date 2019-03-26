<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskDetails extends Model
{
    //
    protected $table        = 'carts_details';
    protected $primaryKey   = 'id';

    public static function getByCarts($id)
    {
        $res = self::where('id_dashboard_task', '=', $id)->first();
        return $res;
    }

    public static function saveDetails($verb)
    {
        self::where('id_dashboard_task', '=', $verb->input('id'))->update(['description'=>$verb->input('description'), 'updated_at'=>@date('Y-m-d H:i:s')]);
    }

    public static function create($id)
    {
        $count                      = self::where('id_dashboard_task', '=', $id)->count();
        $data['id_dashboard_task']  = $id;
        $data['description']        = '';
        $data['position']           = $count + 1;
        $data['created_at']         = @date('Y-m-d H:i:s');
        $data['updated_at']         = @date('Y-m-d H:i:s');
        self::insert($data);
    }

    public static function updateDueDate($data)
    {
        if($data['dueDate'] != '')
        {
            $dtime = \DateTime::createFromFormat("d/m/Y H:i", $data['dueDate']);
            $timestamp = $dtime->getTimestamp();
            $dueDate['due_date'] = date('Y-m-d H:i:s', $timestamp);

            self::where('id', '=', $data['id'])->update($dueDate);
        }
        else
        {
            $dueDate['due_date'] = '0000-00-00 00:00:00';
            self::where('id', '=', $data['id'])->update($dueDate);
        }

    }
}

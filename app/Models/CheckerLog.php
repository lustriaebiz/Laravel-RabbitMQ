<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckerLog extends Model
{
	protected $connection   = 'mysql';
	protected $table        = 'checker_log';
	protected $primaryKey   = 'id';

	protected $hidden       = [];
    protected $dates        = [];
    
	public $timestamps      = false;
	
	public static function create($params)
	{
		$model = new CheckerLog;
        $model->topic_name	= $params['topic_name'];
        $model->queue_name	= $params['queue_name'];
        $model->message     = $params['message'];
        
        $model->save();
        
        return $model;
	}

}

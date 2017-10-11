<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model {
    protected $table = 'log';
    protected $fillable = ['route', 'from', 'to', 'when_to_leave', 'left', 'when_to_arrive', 'arrived', 'comment'];    
}

<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * @var string
     */
    protected $table = "tasks";

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'status',
        'name',
        'email',
        'text',
        'user_id',
        'created_at',
        'updated_at'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
    ];



}
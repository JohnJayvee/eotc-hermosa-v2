<?php

namespace App\Laravel\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Laravel\Traits\DateFormatter;

use Carbon, Helper, Str;

class Assessment extends Authenticatable{

    use Notifiable,SoftDeletes,DateFormatter;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = "assessment";

    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = "master_db";

    /**
     * Enable soft delete in table
     * @var boolean
     */
    protected $softDelete = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    protected $appends = [];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];


    public function transaction(){
        return $this->BelongsTo("App\Laravel\Models\BusinessTransaction",'transaction_id','id');
    }

    public function department(){
        return $this->BelongsTo("App\Laravel\Models\Department",'department_id','id');
    }

   
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name','company_id'];
    public function company(){

        return $this->hasOne('App\Models\Companies', 'id', 'company_id');
    }
}

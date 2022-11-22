<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\IndustryOfCompanies;
class Companies extends Model
{
    public $timestamps = false;
    protected $table = 'companies';
    protected $fillable = ['name','logo'];
    use HasFactory;
    public  function getWithName(){

        
        return $this->hasManyThrough(
            'App\Models\Industries',
            'App\Models\IndustryOfCompanies',
            'company_id', 
            'id', 
            'id', 
            'industry_id' 
        );
    }

    public function industry(){
        return $this->hasMany('App\Models\IndustryOfCompanies', "company_id", "id");
    }
}

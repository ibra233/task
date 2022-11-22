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

        // return self::select('*')->rightJoin('industry_of_companies','industry_of_companies.company_id','companies.id')->get();
        // return $this->hasMany('App\Models\IndustryOfCompanies','company_id', 'id');
        return $this->hasManyThrough(
            'App\Models\Industries',
            'App\Models\IndustryOfCompanies',
            'company_id', // Foreign key on the industryofcompanies table...
            'id', // Foreign key on the industry table...
            'id', // Local key on the company table...
            'industry_id' // Local key on the industryofcompanies table...
        );
    }

    public function service(){
        return $this->hasMany('App\Models\IndustryOfCompanies', "company_id", "id");
    }
}

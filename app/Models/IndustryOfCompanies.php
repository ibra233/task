<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndustryOfCompanies extends Model
{
    public $timestamps = false;
    protected $table = 'industry_of_companies';
    protected $fillable = ['industry_id','company_id'];
    use HasFactory;
}

<?php

namespace App\Http\Controllers;

use App\Models\IndustryOfCompanies;
class IndustryOfCompaniesController extends Controller
{
    //
    public function delete($companyId,$industryId){
        IndustryOfCompanies::where('company_id',$companyId)->where('industry_id',$industryId)->delete();

        return response()->json(__('view.notification-company-industry-delete'));
    }
}

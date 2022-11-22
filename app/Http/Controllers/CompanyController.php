<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;
use App\Models\Companies;
use App\Models\Industries;
use Illuminate\Support\Facades\Storage;
use App\Jobs\SendEmailJob;
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            return datatables()->collection(Companies::with('getWithName')->get())->toJson();
        }
        $industries = Industries::all();
        return view('companies', compact('industries'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $validated = $request->validated();

        $company = new Companies($validated);
        $company->logo = Storage::put('public', $validated['logo']);
        $company->save();
        if ($validated['company_industry'][0] != null) {
        $data = [];
        foreach ($validated['company_industry'] as  $industry) {
            $data[] = ['industry_id' => $industry];
        }
        $company->service()->createMany($data);
    }
        $details['email'] = $request->user()->email;
        $details['name'] = $validated['name'];
        SendEmailJob::dispatchAfterResponse($details);
        return response()->json(__('view.notication-company-add'));
    }



    public function updateCompany(CompanyRequest $request, $id)
    {
        $validated = $request->validated();
        $company = Companies::find($id);
        $company->name = $validated['name'];
        if (isset($validated['logo'])) {
            Storage::delete($company->logo);
            $company->logo = Storage::put('public', $validated['logo']);
        }
        $company->save();
        if ($validated['company_industry'][0] != null) {
            $data = [];
            foreach ($validated['company_industry'] as  $industry) {
                $data[] = ['industry_id' => $industry];
            }
            $company->service()->createMany($data);
        }

        return response()->json(__('view.notication-company-update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $company = Companies::find($id);
        Storage::delete($company->logo);
        $company->delete();
        return response()->json(__('view.notication-company-delete'));
    }
}

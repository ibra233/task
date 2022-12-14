<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Jobs\SendEmailJob;
use App\Models\Companies;
use App\Models\Industries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
     * Şirketlere yeni bir eleman eklemeye yarar. Şirket adı göndermeniz yeterli.
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
            $company->industry()->createMany($data);
        }
        $details['email'] = 'brnysn@gmail.com';
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
        // if ($validated['company_industry'][0] != null) {
        //     $data = [];
        //     foreach ($validated['company_industry'] as  $industry) {
        //         $data[] = ['industry_id' => $industry];
        //     }
        //     $company->industry()->createMany($data);
        // }
        $company->industries()->sync($validated['company_industry']);

        return response()->json(__('view.notication-company-update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Companies $company)
    {
        Storage::delete($company->logo);
        $company->delete();

        return response()->json(__('view.notication-company-delete'));
    }
}

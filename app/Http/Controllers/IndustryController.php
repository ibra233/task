<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndustryRequest;
use App\Models\Industries;
use Illuminate\Http\Request;

class IndustryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->collection(Industries::all())->toJson();
        }

        return view('industries');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(IndustryRequest $request)
    {
        $validated = $request->validated();

        $industry = new Industries($validated);
        $industry->save();

        return response()->json(__('view.notication-industry-delete'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IndustryRequest $request)
    {
        $validated = $request->validated();

        $industry = new Industries($validated);
        $industry->save();

        return response()->json(__('view.notication-industry-add'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(IndustryRequest $request, $id)
    {
        $validated = $request->validated();

        Industries::where('id', $id)->update($validated);

        return response()->json(__('view.notication-industry-update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Industries::where('id', $id)->delete();

        return response()->json(__('view.notication-industry-delete'));
    }
}

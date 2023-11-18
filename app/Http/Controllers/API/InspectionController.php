<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inspection;

class InspectionController extends Controller
{
    public function index()
    {
        return Inspection::paginate(15)->withQueryString();
    }
    public function store(Request $request)
    {
        return Inspection::create($request->all());
    }

    public function show($id)
    {
        return Inspection::find($id);
    }

    public function update(Request $request, $id)
    {
        $inspection = Inspection::findOrFail($id);
        $inspection->update($request->all());
        return $inspection;
    }

    public function destroy($id)
    {
        Inspection::find($id)->delete();
        return 204;
    }

}
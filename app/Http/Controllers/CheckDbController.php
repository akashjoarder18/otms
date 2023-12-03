<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CheckDbController extends Controller
{

    public function list(Request $request, $table, $id = null, $delete = null)
    {
        $query = DB::table($table)
            ->where(function ($query) use ($id) {
                if ($id) {
                    $query->where('id', $id);
                }
            });

        if ($id) {
            if ($delete == 'delete') {
                $data = $query->delete();
            } else {
                $data = $query->first();
            }
        } else {
            $data = $query->paginate();
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SyncController extends Controller
{
    private $API_KEY = 'SYNC123456';

    public function sync(Request $request)
    {
        // cek API KEY
        if ($request->header('API-KEY') !== $this->API_KEY) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $table = $request->table;
        $data = $request->data;

        DB::connection('sikawan')->table($table)->updateOrInsert(
            ['id' => $data['id']],
            $data
        );

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function delete(Request $request)
    {
        // cek API KEY
        if ($request->header('API-KEY') !== $this->API_KEY) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $table = $request->table;
        $id = $request->id;

        DB::connection('sikawan')->table($table)->where('id',$id)->delete();

        return response()->json([
            'status' => 'deleted',
        ]);
    }
}

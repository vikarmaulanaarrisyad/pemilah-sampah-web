<?php

namespace App\Http\Controllers;

use App\Models\Sampah;
use Illuminate\Http\Request;

class ApiSensorDataController extends Controller
{
    public function store(Request $request)
    {
        $data = [
            'data_waktu' => date('Y-m-d H:i:s'),
            'kapasitas_organik' => $request->kapasitas_organik,
            'kapasitas_anorganik' => $request->kapasitas_anorganik,
            'kapasitas_logam' => $request->kapasitas_logam,
            'tinggi_organik' => $request->tinggi_organik,
            'tinggi_anorganik' => $request->tinggi_anorganik,
            'tinggi_logam' => $request->tinggi_logam,

        ];
        Sampah::create($data);

        return response()->json(['message' => 'Data berhasil disimpan',], 201);
    }

    public function deleteAllSampahData()
    {
        Sampah::truncate();
        return response()->json(['message' => 'All data has been deleted successfully.']);
    }
}

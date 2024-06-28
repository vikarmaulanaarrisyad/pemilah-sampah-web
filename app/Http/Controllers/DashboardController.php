<?php

namespace App\Http\Controllers;

use App\Models\Sampah;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function fetchDataAll()
    {
        // Ambil 5 data terbaru dari database
        $sampahData = Sampah::orderBy('data_waktu', 'desc')->limit(5)->get()->reverse();

        // Format data untuk grafik
        $data = [
            'logam' => [
                'listTanggal' => $sampahData->pluck('data_waktu')->toArray(),
                'listKapasitas' => $sampahData->pluck('kapasitas_logam')->toArray()
            ],
            'organik' => [
                'listTanggal' => $sampahData->pluck('data_waktu')->toArray(),
                'listKapasitas' => $sampahData->pluck('kapasitas_organik')->toArray()
            ],
            'anorganik' => [
                'listTanggal' => $sampahData->pluck('data_waktu')->toArray(),
                'listKapasitas' => $sampahData->pluck('kapasitas_anorganik')->toArray()
            ]
        ];

        return response()->json($data);
    }

    public function getSampahData()
    {
        $sampahData = Sampah::orderBy('data_waktu', 'desc')->limit(5)->get();

        return DataTables::of($sampahData)
            ->addIndexColumn()
            ->editColumn('data_waktu', function ($row) {
                return $row->data_waktu;
            })
            ->make(true);
    }
}

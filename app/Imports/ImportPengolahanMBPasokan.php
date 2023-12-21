<?php

namespace App\Imports;

use App\Models\Pengolahan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\Auth;

class ImportPengolahanMBPasokan implements ToModel, WithStartRow, WithMultipleSheets
{

    /**
     * @return int
     */
    protected $requestData;

    public function __construct($requestData)
    {
        $this->requestData = $requestData;
    }

    public function sheets(): array
    {
        return [
            0 => $this, // 0 adalah indeks sheet pertama
            // Tambahkan sheet lain jika diperlukan
        ];
    }

    public function startRow(): int
    {
        return 2; // Mulai membaca data dari baris kedua (baris pertama dilewati sebagai header)
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Pengolahan([
            'badan_usaha_id' => Auth::user()->badan_usaha_id,
            // 'izin_id' => '1',
            'bulan' => $this->requestData,
            'kategori_pemasok' => $row[0],
            'intake_kilang' => $row[1],
            'provinsi' => $row[2],
            'kabupaten_kota' => $row[3],
            'volume' => $row[4],
            'satuan' => $row[5],
            'keterangan' => $row[6],
            'jenis' => 'Minyak Bumi',
            'tipe' => 'Pasokan',
        ]);
    }
}
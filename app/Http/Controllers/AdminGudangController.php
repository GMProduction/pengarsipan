<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Arsip;
use App\Models\Perusahaan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminGudangController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('admingudang.dashboard');
    }

    public function arsip_page() {
        $tahun = Arsip::groupBy('tahun_pajak')->get('tahun_pajak');
        $perusahaan = Perusahaan::all();
        return view('admingudang.arsip')->with([
            'tahun' => $tahun,
            'perusahaan' => $perusahaan
        ]);
    }

    public function create_arsip() {
        try {
            setlocale(LC_TIME, 'id_ID');
            $data = [
                'perusahaan_id' => $this->postField('perusahaan'),
                'nama' => $this->postField('nama'),
                'tanggal' => Carbon::now(),
                'tahun_pajak' => $this->postField('tahun'),
                'keterangan' => $this->postField('keterangan'),
                'baris' => $this->postField('baris'),
                'sisi' => $this->postField('sisi'),
                'rak' => $this->postField('rak'),
                'lantai' => $this->postField('lantai'),
                'box' => $this->postField('box'),
                'url' => null,
                'status' => 0,
            ];

            if ($file = $this->request->file('pdf')) {
                $ext = $file->getClientOriginalExtension();
                $target = uniqid('npwp-') . '.' . $ext;
                $data['url'] = '/arsip/' . $target;
                $this->uploadImage('pdf', $target, 'arsip');
            }
            Arsip::create($data);
            return redirect('/gudang/arsip')->with(['success' => 'Berhasil Menambahkan Data...']);
        }catch (\Exception $e) {
            return redirect('/gudang/arsip')->with(['failed' => 'Terjadi Kesalahan' . $e->getMessage()]);
        }
    }
}

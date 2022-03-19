<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Arsip;
use App\Models\Perusahaan;

class ArsipController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $tahun = Arsip::groupBy('tahun_pajak')->get('tahun_pajak');
        return view('admin.arsip')->with([
            'tahun' => $tahun
        ]);
    }

    public function get_data_arsip()
    {
        try {
            $tahun = $this->field('tahun') ?? '';
            $query = Arsip::with('perusahaan');
            if($tahun !== '') {
                $query->where('tahun_pajak', $tahun);
            }
            $data = $query->get();
            return $this->jsonResponse('success', 200, $data);
        }catch (\Exception $e) {
            return $this->jsonResponse('Terjadi Kesalahan', 500);
        }
    }

    public function confirm_arsip()
    {
        try {
            $arsip = Arsip::find($this->postField('id'));
            $status = $this->postField('status');
            $data = [
                'status' => $status
            ];
            $arsip->update($data);
            return $this->jsonResponse('success', 200);
        }catch (\Exception $e) {
            return $this->jsonResponse('Terjadi Kesalahan', 500);
        }
    }

    public function destroy_arsip()
    {
        try {
            Arsip::destroy($this->postField('id'));
            return $this->jsonResponse('success', 200);
        }catch (\Exception $e) {
            return $this->jsonResponse('Terjadi Kesalahan', 500);
        }
    }

}

<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PerusahaanController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $perusahaan = Perusahaan::with('user')->get();
        return view('admin.perusahaan')->with([
            'data' => $perusahaan
        ]);
    }

    public function create()
    {
        try {
            User::create([
                'username' => $this->postField('username'),
                'password' => Hash::make($this->postField('password')),
                'role' => 'admin'
            ]);
            return redirect('/admin/admin')->with(['success' => 'Berhasil Menambahkan Data...']);
        } catch (\Exception $e) {
            return redirect('/admin/admin')->with(['failed' => 'Terjadi Kesalahan...']);
        }
    }

    public function patch() {
        try {
            $user = User::find($this->postField('id-edit'));
            if($user === null) {
                return redirect('/admin/admin')->with(['failed' => 'User Not Found!']);
            }
            $data = [
                'username' => $this->postField('username-edit')
            ];

            if($this->postField('password-edit') !== '') {
                $data['password'] = Hash::make($this->postField('password-edit'));
            }
            $user->update($data);
            return redirect('/admin/admin')->with(['success' => 'Berhasil Merubah Data']);
        }catch (\Exception $e) {
            return redirect('/admin/admin')->with(['failed' => 'Terjadi Kesalahan']);
        }
    }

    public function delete() {
        try {
            User::destroy($this->postField('id'));
            return $this->jsonResponse('success', 200);
        }catch (\Exception $e) {
            return $this->jsonResponse('Gagal Menghapus Data', 500);
        }
    }
}

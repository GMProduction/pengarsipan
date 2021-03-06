<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $user = User::where('role', '!=', 'perusahaan')->get();
        return view('admin.dataadmin')->with([
            'data' => $user
        ]);
    }

    public function create()
    {
        try {
            User::create([
                'username' => $this->postField('username'),
                'password' => Hash::make($this->postField('password')),
                'role' => $this->postField('role')
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
                'username' => $this->postField('username-edit'),
                'role' => $this->postField('role-edit')
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

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

            $data_user = [
                'username' => $this->postField('username'),
                'password' => $this->postField('password'),
                'role' => 'perusahaan'
            ];

            $user = User::create($data_user);

            $data = [
                'user_id' => $user->id,
                'nama' => $this->postField('nama'),
                'alamat' => $this->postField('alamat'),
                'no_hp' => $this->postField('no_hp'),
                'npwp' => $this->postField('npwp'),
                'npwp_url' => null
            ];

            if ($file = $this->request->file('npwp_url')) {
                $ext = $file->getClientOriginalExtension();
                $target = uniqid('npwp-') . '.' . $ext;
                $data['npwp_url'] = '/npwp/' . $target;
                $this->uploadImage('npwp_url', $target, 'npwp');
            }
            Perusahaan::create($data);
            return redirect('/admin/perusahaan')->with(['success' => 'Berhasil Menambahkan Data...']);
        } catch (\Exception $e) {
            return redirect('/admin/perusahaan')->with(['failed' => 'Terjadi Kesalahan...' . $e->getMessage()]);
        }
    }

    public function patch()
    {
        try {
            $perusahaan = Perusahaan::find($this->postField('id-edit'));

            if ($perusahaan === null) {
                return redirect('/admin/perusahaan')->with(['failed' => 'Perusahaan Not Found!']);
            }

            $user = User::find($perusahaan->user_id);

            if ($user === null) {
                return redirect('/admin/perusahaan')->with(['failed' => 'User Not Found!']);
            }

            $data_user = [
                'username' => $this->postField('username-edit')
            ];

            if ($this->postField('password-edit') !== '') {
                $data_user['password'] = Hash::make($this->postField('password-edit'));
            }
            $user->update($data_user);

            $data = [
                'username' => $this->postField('username-edit')
            ];

            if ($this->postField('password-edit') !== '') {
                $data['password'] = Hash::make($this->postField('password-edit'));
            }
            $user->update($data);

            $data = [
                'nama' => $this->postField('nama-edit'),
                'alamat' => $this->postField('alamat-edit'),
                'no_hp' => $this->postField('no_hp-edit'),
                'npwp' => $this->postField('npwp-edit'),
            ];

            if ($file = $this->request->file('npwp_url-edit')) {
                $ext = $file->getClientOriginalExtension();
                $target = uniqid('npwp-') . '.' . $ext;
                $data['npwp_url'] = '/npwp/' . $target;
                $this->uploadImage('npwp_url-edit', $target, 'npwp');
            }
            $perusahaan->update($data);
            return redirect('/admin/perusahaan')->with(['success' => 'Berhasil Merubah Data']);
        } catch (\Exception $e) {
            return redirect('/admin/perusahaan')->with(['failed' => 'Terjadi Kesalahan' . $e->getMessage()]);
        }
    }

    public function delete()
    {
        try {
            User::destroy($this->postField('id'));
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('Gagal Menghapus Data', 500);
        }
    }
}

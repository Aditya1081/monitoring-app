<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; 
use App\Models\DataSantriModel;
use App\Models\KamarSantriModel;
use App\Models\ParalelModel;
use App\Models\JilidModel;
use App\Models\KelasMadinModel;
use App\Models\User;


class DataSantriCtrl extends Controller
{
    protected $dataSantriModel;
    protected $kamarModel;
    protected $jilidModel;
    protected $kelasModel;
    protected $madinModel;

    public function __construct()
    {
        $this->dataSantriModel = new DataSantriModel();  // Inisialisasi DataSantriModel
        $this->kamarModel = new KamarSantriModel();  // Inisialisasi KamarModel
        $this->kelasModel = new ParalelModel();  // Inisialisasi KamarModel
        $this->jilidModel = new JilidModel();  // Inisialisasi KamarModel
        $this->madinModel = new KelasMadinModel();  // Inisialisasi KamarModel
        $this->users = new User();
    }

    // Menampilkan daftar santri
    public function index()
    {
        $totalItems = DataSantriModel::count();

        $santris = KamarSantriModel::with('kamar');
        $santris = ParalelModel::with('kelas');
        $santris = $this->dataSantriModel->SimplePaginate(5); // Mengambil semua data santri
        return view('data_santri.index', compact('santris', 'totalItems'));
    }

    // Menampilkan detail data santri
    public function show($id)
    {
        $santri = DataSantriModel::find($id); // Mengambil data santri berdasarkan ID
        return view('data_santri.detail', compact('santri')); // Menampilkan view detail santri
    }

    // Menampilkan form untuk menambahkan santri baru
    public function create()
    {
        $kamarList = $this->kamarModel->all(); // Mendapatkan daftar kamar untuk dropdown
        $kelasList = $this->kelasModel->all(); // Mendapatkan daftar kamar untuk dropdown
        $jilidList = $this->jilidModel->all(); // Mendapatkan daftar kamar untuk dropdown
        $madinList = $this->madinModel->all(); // Mendapatkan daftar kamar untuk dropdown
        return view('data_santri.create', compact('kamarList', 'kelasList', 'jilidList', 'madinList'));
    }

    // Menyimpan data santri yang baru dibuat
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nama_santri' => 'required|string|max:50',
    //         'id_kamar' => 'required',
    //         'id_kelas' => 'required',
    //         'NIK' => 'required|numeric|digits_between:10,16|unique:tb_data_santri,NIK',
    //         'NIS' => 'required|numeric|digits_between:10,16|unique:tb_data_santri,NIS',
    //         'NISN' => 'required|numeric|digits_between:10,16|unique:tb_data_santri,NISN',
    //         'kota_lahir' => 'required|string|max:50',
    //         'tanggal_lahir' => 'required|date',
    //         'jenis_kelamin' => 'required',
    //         'alamat' => 'required',
    //         'no_telp_wali' => 'required|numeric|digits_between:10,15',
    //         'nama_wali_santri' => 'required|string|max:50',
    //         'no_va' => 'required|numeric|digits_between:1,15',
    //     ], [
    //         'nama_santri.required' => 'Kolom nama santri wajib diisi.',
    //         'nama_santri.string' => 'Kolom nama santri harus berupa teks.',
    //         'nama_santri.max' => 'Kolom nama santri tidak boleh lebih dari 50 karakter.',

    //         'id_kamar.required' => 'Kolom id kamar wajib diisi.',

    //         'NIK.required' => 'Kolom NIK wajib diisi.',
    //         'NIK.numeric' => 'Kolom NIK harus berupa angka.',
    //         'NIK.unique' => 'Kolom NIK sudah terdaftar, gunakan NIK yang lain.',
    //         'NIK.digits_between:10,16' => 'Kolom NIK harus berisi minimal 10 karakter dan maksimal 16 karakter',

    //         'NIS.required' => 'Kolom NIS wajib diisi.',
    //         'NIS.numeric' => 'Kolom NIS harus berupa angka.',
    //         'NIS.unique' => 'Kolom NIS sudah terdaftar, gunakan NIS yang lain.',
    //         'NIS.digits_between:10,16' => 'Kolom NIS harus berisi minimal 10 karakter dan maksimal 16 karakter',

    //         'NISN.required' => 'Kolom NISN wajib diisi.',
    //         'NISN.numeric' => 'Kolom NISN harus berupa angka.',
    //         'NISN.unique' => 'Kolom NISN sudah terdaftar, gunakan NISN yang lain.',
    //         'NISN.digits_between:10,16' => 'Kolom NISN harus berisi minimal 10 karakter dan maksimal 16 karakter',

    //         'kota_lahir.required' => 'Kolom kota lahir wajib diisi.',
    //         'kota_lahir.string' => 'Kolom kota lahir harus berupa teks.',
    //         'kota_lahir.max' => 'Kolom kota lahir tidak boleh lebih dari 50 karakter.',

    //         'tanggal_lahir.required' => 'Kolom tanggal lahir wajib diisi.',
    //         'tanggal_lahir.date' => 'Kolom tanggal lahir harus berupa tanggal yang valid.',

    //         'jenis_kelamin.required' => 'Kolom jenis kelamin wajib diisi.',

    //         'alamat.required' => 'Kolom alamat wajib diisi.',

    //         'no_telp_wali.required' => 'Kolom nomor telepon wali wajib diisi.',
    //         'no_telp_wali.numeric' => 'Kolom nomor telepon wali harus berupa angka.',
    //         'no_telp_wali.digits_between' => 'Kolom nomor telepon wali harus berisi angka dengan panjang antara 10 hingga 15 digit.',

    //         'no_va.required' => 'Kolom nomor VA wajib diisi.',
    //         'no_va.numeric' => 'Kolom nomor VA harus berupa angka.',
    //         'no_va.digits_between' => 'Kolom nomor VA harus berisi angka dengan panjang antara 1 hingga 15 digit.',

    //         'nama_wali_santri.required' => 'Kolom nama wali santri wajib diisi.',
    //         'nama_wali_santri.string' => 'Kolom nama wali santri harus berupa teks.',
    //         'nama_wali_santri.max' => 'Kolom nama wali santri tidak boleh lebih dari 50 karakter.',

    //     ]);

    //     // Simpan data santri ke model
    //     $this->dataSantriModel->create($request->all());
    //     $this->users->create([
    //         'name' => $request->nama_wali_santri,
    //         'username' => $request->nik,
    //         'password' => Hash::make($request->password), // Pastikan untuk menghash password
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ]);

    //     $users->assignRole('user');

    //     return redirect()->route('data_santri.index')->with('success', 'Data Santri berhasil ditambahkan.');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'nama_santri' => 'required|string|max:50',
            'id_kamar' => 'required',
            'id_kelas' => 'required',
            'NIK' => 'required|numeric|digits_between:10,16|unique:tb_data_santri,NIK',
            'NIS' => 'required|numeric|digits_between:10,16|unique:tb_data_santri,NIS',
            'NISN' => 'required|numeric|digits_between:10,16|unique:tb_data_santri,NISN',
            'kota_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'no_telp_wali' => 'required|numeric|digits_between:10,15',
            'nama_wali_santri' => 'required|string|max:50',
            'no_va' => 'required|numeric|digits_between:1,15',
        ], [
            'nama_santri.required' => 'Kolom nama santri wajib diisi.',
            'nama_santri.string' => 'Kolom nama santri harus berupa teks.',
            'nama_santri.max' => 'Kolom nama santri tidak boleh lebih dari 50 karakter.',
    
            'id_kamar.required' => 'Kolom id kamar wajib diisi.',
    
            'NIK.required' => 'Kolom NIK wajib diisi.',
            'NIK.numeric' => 'Kolom NIK harus berupa angka.',
            'NIK.unique' => 'Kolom NIK sudah terdaftar, gunakan NIK yang lain.',
            'NIK.digits_between' => 'Kolom NIK harus berisi minimal 10 karakter dan maksimal 16 karakter',
    
            'NIS.required' => 'Kolom NIS wajib diisi.',
            'NIS.numeric' => 'Kolom NIS harus berupa angka.',
            'NIS.unique' => 'Kolom NIS sudah terdaftar, gunakan NIS yang lain.',
            'NIS.digits_between' => 'Kolom NIS harus berisi minimal 10 karakter dan maksimal 16 karakter',
    
            'NISN.required' => 'Kolom NISN wajib diisi.',
            'NISN.numeric' => 'Kolom NISN harus berupa angka.',
            'NISN.unique' => 'Kolom NISN sudah terdaftar, gunakan NISN yang lain.',
            'NISN.digits_between' => 'Kolom NISN harus berisi minimal 10 karakter dan maksimal 16 karakter',
    
            'kota_lahir.required' => 'Kolom kota lahir wajib diisi.',
            'kota_lahir.string' => 'Kolom kota lahir harus berupa teks.',
            'kota_lahir.max' => 'Kolom kota lahir tidak boleh lebih dari 50 karakter.',
    
            'tanggal_lahir.required' => 'Kolom tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Kolom tanggal lahir harus berupa tanggal yang valid.',
    
            'jenis_kelamin.required' => 'Kolom jenis kelamin wajib diisi.',
    
            'alamat.required' => 'Kolom alamat wajib diisi.',
    
            'no_telp_wali.required' => 'Kolom nomor telepon wali wajib diisi.',
            'no_telp_wali.numeric' => 'Kolom nomor telepon wali harus berupa angka.',
            'no_telp_wali.digits_between' => 'Kolom nomor telepon wali harus berisi angka dengan panjang antara 10 hingga 15 digit.',
    
            'no_va.required' => 'Kolom nomor VA wajib diisi.',
            'no_va.numeric' => 'Kolom nomor VA harus berupa angka.',
            'no_va.digits_between' => 'Kolom nomor VA harus berisi angka dengan panjang antara 1 hingga 15 digit.',
    
            'nama_wali_santri.required' => 'Kolom nama wali santri wajib diisi.',
            'nama_wali_santri.string' => 'Kolom nama wali santri harus berupa teks.',
            'nama_wali_santri.max' => 'Kolom nama wali santri tidak boleh lebih dari 50 karakter.',
        ]);
    
        // Simpan data santri ke model dan dapatkan instance modelnya
        $santri = $this->dataSantriModel->create($request->all());
    
        // Gunakan id_santri dari instance model yang baru saja dibuat
        $user = $this->users->create([
            'name' => $request->nama_wali_santri,
            'username' => $request->NIK, // gunakan NIK atau sesuai kebutuhan
            'password' => Hash::make($request->password), // Pastikan untuk menghash password
            'id_santri' => $santri->id_santri, // Simpan id_santri di user
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        // Assign role to user
        $user->assignRole('user');
    
        return redirect()->route('data_santri.index')->with('success', 'Data Santri berhasil ditambahkan.');
    }
    

    // Menampilkan form untuk mengedit data santri
    public function edit(DataSantriModel $santri)
    {
        $kamarList = $this->kamarModel->all(); // Mendapatkan daftar kamar untuk dropdown
        $kelasList = $this->kelasModel->all(); // Mendapatkan daftar kamar untuk dropdown
        $madinList = $this->madinModel->all(); // Mendapatkan daftar kamar untuk dropdown
        $jilidList = $this->jilidModel->all(); // Mendapatkan daftar kamar untuk dropdown
        return view('data_santri.edit', compact('santri', 'kamarList', 'kelasList', 'madinList', 'jilidList'));
    }

    // Menyimpan perubahan pada data santri
    public function update(Request $request, DataSantriModel $santri)
    {
        $request->validate([
            'nama_santri' => 'required|string|max:50',
            'id_kamar' => 'required',
            'id_kelas' => 'required',
            'NIK' => [
                'required',
                'numeric',
                'digits_between:10,16',
                Rule::unique('tb_data_santri', 'NIK')->ignore($santri->id_santri, 'id_santri'),
            ],
            'NIS' => [
                'required',
                'numeric',
                'digits_between:10,16',
                Rule::unique('tb_data_santri', 'NIS')->ignore($santri->id_santri, 'id_santri'),
            ],
            'NISN' => [
                'required',
                'numeric',
                'digits_between:10,16',
                Rule::unique('tb_data_santri', 'NISN')->ignore($santri->id_santri, 'id_santri'),
            ],
            'kota_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'no_telp_wali' => 'required|numeric|digits_between:10,15',
        ]);

        // Update data santri
        $santri->update($request->all());

        return redirect()->route('data_santri.index')->with('success', 'Data santri berhasil diperbarui.');
    }


    // Menghapus data santri
    public function destroy($id)
    {
        // Temukan model berdasarkan ID yang diberikan
        $santri = DataSantriModel::find($id);

        if (!$santri) {
            // Jika data santri tidak ditemukan, arahkan kembali dengan pesan error
            return redirect()->route('data_santri.index')->with('error', 'Santri tidak ditemukan.');
        }

        // Hapus data santri yang ditemukan
        $santri->delete();

        // Arahkan kembali dengan pesan sukses
        return redirect()->route('data_santri.index')->with('success', 'Santri berhasil dihapus.');
    }

    // Controller method to get santri by kamar
    public function getSantriByKamar(Request $request)
    {
        $id_kamar = $request->input('id_kamar');

        $santriList = DataSantriModel::where('id_kamar', $id_kamar)
            ->orderBy('nama_santri', 'asc')
            ->get();

        return response()->json($santriList);
    }

}

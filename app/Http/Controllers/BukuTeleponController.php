<?php

namespace App\Http\Controllers;

use App\Models\BukuTelepon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuTeleponController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        // Memanggil fungsi dari Model Gabungan
        $bukuTelepon = BukuTelepon::getCombinedData($search);

        return view('bukuTelepon.index', compact('bukuTelepon'));
    }

    public function destroy($id)
    {
        // Hapus data di database utama (sipirman)
        DB::table('sipirman.penitip')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Nomor telepon berhasil dihapus.');
    }
}

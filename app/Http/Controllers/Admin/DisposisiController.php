<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Letter;
use App\Models\Disposisi;
use App\Models\Department;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DisposisiController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        $letters = Letter::all();
        $department = Department::all();
        if (Auth::user()->role === 'super_admin') {
            return view('pages.admin.disposisi.create', [
                'letters' => $letters,
                'department' => $department,
            ]);
        } elseif (Auth::user()->role === 'user') {
            return view('pages.user.disposisi-user.create', [
                'letters' => $letters,
                'department' => $department,
            ]);
        }
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'letter_id' => 'required',
            'lampiran' => 'required',
            'status' => 'required',
            'sifat' => 'required',
            'petunjuk' => 'required',
            'catatan_rektor' => 'required',
            'tgl_selesai' => 'required',
            'kepada' => 'required',
            'petunjuk_kpd_1' => 'required',
            'tgl_selesai_2',
            'penerima_2',
            'check_status' => 'in:pending,approved,rejected',
            'letter_file' => 'mimes:pdf|file'
        ]);

        if ($request->file('letter_file')) {
            $path = "admin/assets/";
            $file = $request->file('letter_file');

            $validatedData['letter_file'] = $request->file('letter_file')->move($path, strval(time()) . $file->getClientOriginalName());
        }
        if ($request->input('status')) {
            $validatedData['status'] = implode(',', $request->status);
        }
        if ($request->input('sifat')) {
            $validatedData['sifat'] = implode(',', $request->sifat);
        }
        if ($request->input('petunjuk')) {
            $validatedData['petunjuk'] = implode(',', $request->petunjuk);
        }
        if ($request->input('check_status')) {
            $validatedData['check_status'] = 'pending';
        }

        // if ($request->input('penerima_disposisi_2')) {
        //     $validatedData['penerima_disposisi_2'] = implode(',', $request->penerima_disposisi_2);
        // }

        //   ddd($request->all());

        $redirect = Auth::user()->role === 'super_admin' ? 'surat-disposisi' : 'surat-disposisi-user';

        Disposisi::create($validatedData);
        return redirect()
            ->route($redirect)
            ->with('success', 'Sukses! 1 Data Berhasil Disimpan');
    }

    public function disposisi_form()
    {
        if (request()->ajax()) {
            $query = Disposisi::with(['letter'])->latest()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    if (Auth::user()->role === 'super_admin') {
                        return '
                        <a class="btn btn-success btn-xs" href="' . route('detail-disposisi', $item->id) . '">
                            <i class="fa fa-search-plus"></i> &nbsp; Detail
                        </a>
                        <a class="btn btn-primary btn-xs" href="' . route('disposisi.edit', $item->id) . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
                         <a class="btn btn-secondary btn-xs" href="' . route('disposisi-surat', $item->id) . '" target="_blank">
                            <i class="fas fa-print"></i> &nbsp; Cetak
                        </a>
                        <form action="' . route('disposisi.destroy', $item->id) . '" method="POST" onsubmit="return confirm(' . "'Anda akan menghapus item ini dari situs anda?'" . ')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>
                    ';
                    } elseif (Auth::user()->role === 'user') {
                        return '
                        <a class="btn btn-success btn-xs" href="' . route('detail-disposisi-user', $item->id) . '">
                            <i class="fa fa-search-plus"></i> &nbsp; Detail
                        </a>
                        <a class="btn btn-primary btn-xs" href="' . route('disposisi-user.edit', $item->id) . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
                         <a class="btn btn-secondary btn-xs" href="' . route('disposisi-surat-user', $item->id) . '" target="_blank">
                            <i class="fas fa-print"></i> &nbsp; Cetak
                        </a>
                        <form action="' . route('disposisi-user.destroy', $item->id) . '" method="POST" onsubmit="return confirm(' . "'Anda akan menghapus item ini dari situs anda?'" . ')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>
                    ';
                    }
                })
                ->editColumn('post_status', function ($item) {
                    return $item->post_status == 'Published' ? '<div class="badge bg-green-soft text-green">' . $item->post_status . '</div>' : '<div class="badge bg-gray-200 text-dark">' . $item->post_status . '</div>';
                })
                ->addIndexColumn()
                ->removeColumn('id')
                ->rawColumns(['action', 'post_status'])
                ->make();
        }

        if (Auth::user()->role === 'super_admin') {
            return view('pages.admin.disposisi.incoming');
        } elseif (Auth::check() && Auth::user()->role === 'user') {
            return view('pages.user.disposisi-user.incoming');
        }
    }

    public function show($id)
    {
        $item = Disposisi::with(['letter'])->findOrFail($id);

        if (Auth::user()->role === 'super_admin') {
            return view('pages.admin.disposisi.show', [
                'item' => $item,
            ]);
        } elseif (Auth::user()->role === 'user') {
            return view('pages.user.disposisi-user.show', [
                'item' => $item,
            ]);
        }
    }
    public function disposisiprint($id)
    {
        $item = Disposisi::with(['letter'])->findOrFail($id);

        if (Auth::user()->role === 'super_admin') {
            return view('pages.admin.disposisi.print-incoming', [
                'item' => $item,
                'status' => explode(',', $item->status),
                'sifat' => explode(',', $item->sifat),
                'petunjuk' => explode(',', $item->petunjuk),
                'disposisi' => explode(',', $item->letter->disposisi),
            ]);
        } elseif (Auth::user()->role === 'user') {
            return view('pages.user.disposisi-user.print-incoming', [
                'item' => $item,
                'status' => explode(',', $item->status),
                'sifat' => explode(',', $item->sifat),
                'petunjuk' => explode(',', $item->petunjuk),
                'disposisi' => explode(',', $item->letter->disposisi),
            ]);
        }
    }

    public function edit($id)
    {
        $item = Disposisi::findOrFail($id);
        $department = Department::all();
        $letters = Letter::all();

        if (Auth::user()->role === 'super_admin') {
            return view('pages.admin.disposisi.edit', [
                'letters' => $letters,
                'item' => $item,
                'status' => explode(',', $item->status),
                'sifat' => explode(',', $item->sifat),
                'petunjuk' => explode(',', $item->petunjuk),
                'penerima_disposisi_2' => explode(',', $item->penerima_disposisi_2),
                'department' => $department,
            ]);
        } elseif (Auth::user()->role === 'user') {
            return view('pages.user.disposisi-user.edit', [
                'letters' => $letters,
                'item' => $item,
                'status' => explode(',', $item->status),
                'sifat' => explode(',', $item->sifat),
                'petunjuk' => explode(',', $item->petunjuk),
                'penerima_disposisi_2' => explode(',', $item->penerima_disposisi_2),
                'department' => $department,
            ]);
        }
    }

    public function download_letter($id)
    {
        $item = Disposisi::findOrFail($id);

        return Storage::download($item->letter_file);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'letter_id' => 'required',
            'lampiran' => 'required',
            'status' => 'required',
            'sifat' => 'required',
            'petunjuk' => 'required',
            'catatan_rektor' => 'required',
            'tgl_selesai' => 'required',
            'kepada' => 'required',
            'petunjuk_kpd_1' => 'required',
            'tgl_selesai_2',
            'penerima_2',
            'check_status' => 'required|in:pending,approved,rejected',
            'letter_file' => 'mimes:pdf|file'
        ]);

        $item = Disposisi::findOrFail($id);

        if ($request->file('letter_file')) {
            $validatedData['letter_file'] = $request->file('letter_file')->store('assets/letter-file');
        }
        if ($request->input('status')) {
            $validatedData['status'] = implode(',', $request->status);
        }
        if ($request->input('sifat')) {
            $validatedData['sifat'] = implode(',', $request->sifat);
        }
        if ($request->input('petunjuk')) {
            $validatedData['petunjuk'] = implode(',', $request->petunjuk);
        }
        // if ($request->input('penerima_disposisi_2')) {
        //     $validatedData['penerima_disposisi_2'] = implode(',', $request->penerima_disposisi_2);
        // }

        $redirect = Auth::user()->role === 'super_admin' ? 'surat-disposisi' : 'surat-disposisi-user';

        // dd($request->all());

        $item->update($validatedData);

        return redirect()
            ->route($redirect)
            ->with('success', 'Sukses! 1 Data Berhasil Diubah');
    }

    public function destroy($id)
    {
        $item = Disposisi::findorFail($id);
        $redirect = Auth::user()->role === 'super_admin' ? 'surat-disposisi' : 'surat-disposisi-user';
        Storage::delete($item->letter_file);

        $item->delete();

        return redirect()
            ->route($redirect)
            ->with('success', 'Sukses! 1 Data Berhasil Dihapus');
    }
}

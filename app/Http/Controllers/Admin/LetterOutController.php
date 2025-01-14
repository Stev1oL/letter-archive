<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Letterout;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class LetteroutController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        if (Auth::user()->role === 'super_admin') {
            return view('pages.admin.letterout.create');
        } elseif (Auth::user()->role === 'admin') {
            return view('pages.staff.letter-out.create');
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'letter_no' => 'required',
            'letterout_date' => 'required',
            'first_number',
            'temp_number',
            'regarding' => 'required',
            'purpose' => 'required',
            'attribute' => 'required',
            'copy' => 'required',
            'content' => 'required',
            'letter_file' => 'required|mimes:pdf|file',
            'letter_type' => 'required',
        ]);

        if ($request->file('letter_file')) {
            $validatedData['letter_file'] = $request->file('letter_file')->store('public/admin/assets/');
        }

        if ($validatedData['letter_type'] == 'Surat Keluar') {
            $redirect = 'surat-keluar';
        }

        Letterout::create($validatedData);

        return redirect()
            ->route($redirect)
            ->with('success', 'Sukses! 1 Data Berhasil Disimpan');
    }

    public function outgoing_mail()
    {
        if (request()->ajax()) {
            $query = Letterout::latest()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    if (Auth::user()->role === 'super_admin') {
                        return '
                            <a class="btn btn-success btn-xs" href="' . route('detail-surat-keluar', $item->id) . '">
                                <i class="fa fa-search-plus"></i> &nbsp; Detail
                            </a>
                            <a class="btn btn-primary btn-xs" href="' . route('letterout.edit', $item->id) . '">
                                <i class="fas fa-edit"></i> &nbsp; Ubah
                            </a>
                            <form action="' . route('letterout.destroy', $item->id) . '" method="POST" onsubmit="return confirm(' . "'Anda akan menghapus item ini dari situs anda?'" . ')">
                                ' . method_field('delete') . csrf_field() . '
                                <button class="btn btn-danger btn-xs">
                                    <i class="far fa-trash-alt"></i> &nbsp; Hapus
                                </button>
                            </form>
                            <a class="btn btn-info btn-xs" href="' . route('layout-surat-keluar', $item->id) . '" target="_blank">
                                <i class="fas fa-print"></i> &nbsp; Cetak Surat
                            </a>
                        ';
                    } elseif (Auth::user()->role === 'admin') {
                        return '
                            <a class="btn btn-success btn-xs" href="' . route('detail-surat-keluar-staff', $item->id) . '">
                                <i class="fa fa-search-plus"></i> &nbsp; Detail
                            </a>
                            <a class="btn btn-primary btn-xs" href="' . route('letter-out.edit', $item->id) . '">
                                <i class="fas fa-edit"></i> &nbsp; Ubah
                            </a>
                            <form action="' . route('letter-out.destroy', $item->id) . '" method="POST" onsubmit="return confirm(' . "'Anda akan menghapus item ini dari situs anda?'" . ')">
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
            return view('pages.admin.letterout.outgoing');
        } elseif (Auth::user()->role === 'admin') {
            return view('pages.admin.letterout.outgoing');
        }
    }

    public function show($id)
    {
        $item = Letterout::findOrFail($id);

        if (Auth::user()->role === 'super_admin') {
            return view('pages.admin.letterout.show', [
                'item' => $item,
            ]);
        } elseif (Auth::user()->role === 'admin') {
            return view('pages.staff.letter-out.show', [
                'item' => $item,
            ]);
        }
    }

    public function edit($id)
    {
        $item = Letterout::findOrFail($id);

        if (Auth::user()->role === 'super_admin') {
            return view('pages.admin.letterout.edit', [
                'item' => $item,
            ]);
        } elseif (Auth::user()->role === 'admin') {
            return view('pages.staff.letter-out.edit', [
                'item' => $item,
            ]);
        }
    }

    public function download_letter($id)
    {
        $item = Letterout::findOrFail($id);

        return Storage::download($item->letter_file);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'letter_no' => 'required',
            'letterout_date' => 'required',
            'first_number' => 'required',
            'temp_number' => 'required',
            'regarding' => 'required',
            'purpose' => 'required',
            'attribute' => 'required',
            'copy' => 'required',
            'content' => 'required',
            'letter_file' => 'mimes:pdf|file',
            'letter_type' => 'required',
        ]);

        $item = Letterout::findOrFail($id);

        if ($request->file('letter_file')) {
            $validatedData['letter_file'] = $request->file('letter_file')->store('assets/letter-file');
        }
        $redirect = 'surat-keluar';

        $item->update($validatedData);

        return redirect()
            ->route($redirect)
            ->with('success', 'Sukses! 1 Data Berhasil Diubah');
    }

    public function destroy($id)
    {
        $item = Letterout::findorFail($id);

        if ($item->letter_type == 'Surat Keluar') {
            $redirect = 'surat-keluar';
        }

        Storage::delete($item->letter_file);

        $item->delete();

        return redirect()
            ->route($redirect)
            ->with('success', 'Sukses! 1 Data Berhasil Dihapus');
    }

    public function print_letter($id)
    {
        $item = Letterout::findOrFail($id);
        return view('pages.admin.letterout.print-letter', [
            'item' => $item
        ]);
    }
}

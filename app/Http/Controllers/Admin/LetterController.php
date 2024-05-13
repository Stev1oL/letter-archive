<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Department;
use App\Models\Letter;
use App\Models\Sender;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class LetterController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        $departments = Department::all();
        $senders = Sender::all();

        if (Auth::user()->role === 'super_admin') {
            return view('pages.admin.letter.create', [
                'departments' => $departments,
                'senders' => $senders,
            ]);
        } elseif (Auth::user()->role === 'admin') {
            return view('pages.staff.letter-in.create', [
                'departments' => $departments,
                'senders' => $senders,
            ]);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'letter_no' => 'required',
            'letter_date' => 'required',
            'date_received' => 'required',
            'agenda_no' => 'required',
            'regarding' => 'required',
            'disposisi' => 'required',
            'department_id' => 'required',
            'sender_id' => 'required',
            'letter_file' => 'required|mimes:pdf|file',
            'letter_type' => 'required',
        ]);

        if ($request->input('disposisi')) {
            $validatedData['disposisi'] = implode(',', $request->disposisi);
        }
        if ($request->file('letter_file')) {
            $validatedData['letter_file'] = $request->file('letter_file')->store('public/admin/assets/');
        }
        if ($validatedData['letter_type'] == 'Surat Masuk') {
            $redirect = 'surat-masuk';
        }
        Letter::create($validatedData);

        return redirect()
            ->route($redirect)
            ->with('success', 'Sukses! 1 Data Berhasil Disimpan');
    }

    public function incoming_mail()
    {
        if (request()->ajax()) {
            $query = Letter::with(['department', 'sender'])->where('letter_type', 'Surat Masuk')->latest()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    if (Auth::user()->role === 'super_admin') {
                        return '
                        <a class="btn btn-success btn-xs" href="' . route('detail-surat', $item->id) . '">
                            <i class="fa fa-search-plus"></i> &nbsp; Detail
                        </a>
                        <a class="btn btn-primary btn-xs" href="' . route('letter.edit', $item->id) . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
                        <form action="' . route('letter.destroy', $item->id) . '" method="POST" onsubmit="return confirm(' . "'Anda akan menghapus item ini dari situs anda?'" . ')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>
                    ';
                    } elseif (Auth::user()->role === 'admin') {
                        return '
                        <a class="btn btn-success btn-xs" href="' . route('detail-surat-staff', $item->id) . '">
                            <i class="fa fa-search-plus"></i> &nbsp; Detail
                        </a>
                        <a class="btn btn-primary btn-xs" href="' . route('letter-in.edit', $item->id) . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
                        <form action="' . route('letter.destroy', $item->id) . '" method="POST" onsubmit="return confirm(' . "'Anda akan menghapus item ini dari situs anda?'" . ')">
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
            return view('pages.admin.letter.incoming');
        } elseif (Auth::user()->role === 'admin') {
            return view('pages.staff.letter-in.incoming');
        }
    }

    public function outgoing_mail()
    {
        if (request()->ajax()) {
            $query = Letter::with(['department', 'sender'])->where('letter_type', 'Surat Keluar')->latest()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    if (Auth::user()->role === 'super_admin') {
                        return '
                        <a class="btn btn-success btn-xs" href="' . route('detail-surat-staff', $item->id) . '">
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
                    } elseif (Auth::user()->role === 'admin') {
                        return '
                        <a class="btn btn-success btn-xs" href="' . route('detail-surat-staff', $item->id) . '">
                            <i class="fa fa-search-plus"></i> &nbsp; Detail
                        </a>
                        <a class="btn btn-primary btn-xs" href="' . route('staff.letter-in.edit', $item->id) . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
                       
                        <form action="' . route('letter-in.destroy', $item->id) . '" method="POST" onsubmit="return confirm(' . "'Anda akan menghapus item ini dari situs anda?'" . ')">
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
            return view('pages.admin.letter.outgoing');
        } elseif (Auth::user()->role === 'admin') {
            return view('pages.staff.letter-in.outgoing');
        }
    }

    public function show($id)
    {
        $item = Letter::with(['department', 'sender'])->findOrFail($id);

        if (Auth::user()->role === 'super_admin') {
            return view('pages.admin.letter.show', [
                'item' => $item,
            ]);
        } elseif (Auth::user()->role === 'admin') {
            return view('pages.staff.letter-in.show', [
                'item' => $item,
            ]);
        }
    }

    public function edit($id)
    {
        $item = Letter::findOrFail($id);

        $departments = Department::all();
        $senders = Sender::all();

        if (Auth::user()->role === 'super_admin') {
            return view('pages.admin.letter.edit', [
                'departments' => $departments,
                'senders' => $senders,
                'item' => $item,
                'disposisi' => explode(',', $item->disposisi),
            ]);
        } elseif (Auth::user()->role === 'admin') {
            return view('pages.staff.letter-in.edit', [
                'departments' => $departments,
                'senders' => $senders,
                'item' => $item,
                'disposisi' => explode(',', $item->disposisi),
            ]);
        }
    }

    public function download_letter($id)
    {
        $item = Letter::findOrFail($id);

        return Storage::download($item->letter_file);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'letter_no' => 'required',
            'letter_date' => 'required',
            'date_received' => 'required',
            'agenda_no' => 'required',
            'regarding' => 'required',
            'disposisi' => 'required',
            'department_id' => 'required',
            'sender_id' => 'required',
            'letter_file' => 'mimes:pdf|file',
            'letter_type' => 'required',
        ]);

        $item = Letter::findOrFail($id);

        if ($request->file('letter_file')) {
            $validatedData['letter_file'] = $request->file('letter_file')->store('assets/letter-file');
        }
        if ($request->input('disposisi')) {
            $validatedData['disposisi'] = implode(',', $request->disposisi);
        }
        if ($validatedData['letter_type'] == 'Surat Masuk') {
            $redirect = 'surat-masuk';
        }

        $item->update($validatedData);

        return redirect()
            ->route($redirect)
            ->with('success', 'Sukses! 1 Data Berhasil Diubah');
    }

    public function destroy($id)
    {
        $item = Letter::findorFail($id);

        if ($item->letter_type == 'Surat Masuk') {
            if (Auth::user()->role === 'super_admin') {
                $redirect = 'surat-masuk';
            } elseif (Auth::user()->role === 'admin') {
                $redirect = 'staff.letter-in.surat-masuk';
            }
        } else {
            if (Auth::user()->role === 'super_admin') {
                $redirect = 'surat-keluar';
            } elseif (Auth::user()->role === 'admin') {
                $redirect = 'staff.letter-in.surat-keluar';
            }
        }

        Storage::delete($item->letter_file);

        $item->delete();

        return redirect()
            ->route($redirect)
            ->with('success', 'Sukses! 1 Data Berhasil Dihapus');
    }
    public function cobaCetak()
    {
        if (Auth::user()->role === 'super_admin') {
            return view('pages.admin.letter.cetak-disposisi');
        } elseif (Auth::user()->role === 'admin') {
            return view('pages.staff.letter-in.cetak-disposisi');
        }
    }
}

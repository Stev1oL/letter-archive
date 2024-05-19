<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Department;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Department::latest()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    if (Auth::user()->role === 'super_admin') {
                        return '
                        <a class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#updateModal' . $item->id . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
                        <form action="' . route('department.destroy', $item->id) . '" method="POST" onsubmit="return confirm(' . "'Anda akan menghapus item ini dari situs anda?'" . ')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>
                    ';
                    } elseif (Auth::user()->role === 'admin') {
                        return '
                        <a class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#updateModal' . $item->id . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
                        <form action="' . route('department-staff.destroy', $item->id) . '" method="POST" onsubmit="return confirm(' . "'Anda akan menghapus item ini dari situs anda?'" . ')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>
                    ';
                    }
                })
                ->addIndexColumn()
                ->removeColumn('id')
                ->rawColumns(['action'])
                ->make();
        }
        $department = Department::all();

        if (Auth::user()->role === 'super_admin') {
            return view('pages.admin.department.index', [
                'department' => $department
            ]);
        } elseif (Auth::user()->role === 'admin') {
            return view('pages.staff.department-staff.index', [
                'department' => $department
            ]);
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'office' => 'required',
            'institution' => 'required'
        ]);

        $redirect = Auth::user()->role === 'super_admin' ? 'department.index' : 'department-staff.index';

        Department::create([
            'name' => $request->name,
            'office' => $request->office,
            'institution' => $request->institution
        ]);

        return redirect()
            ->route($redirect)
            ->with('success', 'Sukses! 1 Data Berhasil Disimpan');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'office' => 'required',
            'institution' => 'required'
        ]);

        $redirect = Auth::user()->role === 'super_admin' ? 'department.index' : 'department-staff.index';

        Department::where('id', $id)
            ->update([
                'name' => $request->name,
                'office' => $request->office,
                'institution' => $request->institution
            ]);

        return redirect()
            ->route($redirect)
            ->with('success', 'Sukses! 1 Data telah diperbarui');
    }

    public function destroy($id)
    {
        $item = Department::findorFail($id);

        $redirect = Auth::user()->role === 'super_admin' ? 'department.index' : 'department-staff.index';

        $item->delete();

        return redirect()
            ->route($redirect)
            ->with('success', 'Sukses! 1 Data Berhasil Dihapus');
    }
}

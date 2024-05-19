<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = User::latest()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    if (Auth::user()->role === 'super_admin') {
                        return '
                        <a class="btn btn-primary btn-xs" href="' . route('user.edit', $item->id) . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
                        <form action="' . route('user.destroy', $item->id) . '" method="POST" onsubmit="return confirm(' . "'Anda akan menghapus item ini secara permanen dari situs anda?'" . ')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>
                    ';
                    } elseif (Auth::user()->role === 'admin') {
                        return '
                        <a class="btn btn-primary btn-xs" href="' . route('user-staff.edit', $item->id) . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
                        <form action="' . route('user-staff.destroy', $item->id) . '" method="POST" onsubmit="return confirm(' . "'Anda akan menghapus item ini secara permanen dari situs anda?'" . ')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>
                    ';
                    }
                })
                ->editColumn('name', function ($item) {
                    if (Auth::user()->role === 'super_admin') {
                        return $item->profile ?
                            '<div class="d-flex align-items-center">
                                    <div class="avatar me-2"><img class="avatar-img img-fluid" src="' . Storage::url($item->profile) . '" /></div>' .
                            $item->name . '
                                </div>'
                            :
                            '<div class="d-flex align-items-center">
                                    <div class="avatar me-2"><img class="avatar-img img-fluid" src="https://ui-avatars.com/api/?name=' . $item->name . '" /></div>' .
                            $item->name . '
                                </div>';
                    } elseif (Auth::user()->role === 'admin') {
                        return $item->profile ?
                            '<div class="d-flex align-items-center">
                                    <div class="avatar me-2"><img class="avatar-img img-fluid" src="' . Storage::url($item->profile) . '" /></div>' .
                            $item->name . '
                                </div>'
                            :
                            '<div class="d-flex align-items-center">
                                    <div class="avatar me-2"><img class="avatar-img img-fluid" src="https://ui-avatars.com/api/?name=' . $item->name . '" /></div>' .
                            $item->name . '
                                </div>';
                    }
                })
                ->addIndexColumn()
                ->removeColumn('id')
                ->rawColumns(['action', 'name'])
                ->make();
        }

        if (Auth::user()->role === 'super_admin') {
            return view('pages.admin.user.index');
        } elseif (Auth::user()->role === 'admin') {
            return view('pages.staff.user-staff.index');
        }
    }

    public function create()
    {
        if (Auth::user()->role === 'super_admin') {
            return view('pages.admin.user.create');
        } elseif (Auth::user()->role === 'admin') {
            return view('pages.staff.user-staff.create');
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255',
            'role' => 'required|in:' . implode(',', [User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN, User::ROLE_USER])
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $redirect = Auth::user()->role === 'super_admin' ? 'user.index' : 'user-staff.index';

        User::create($validatedData);

        return redirect()
            ->route($redirect)
            ->with('success', 'Sukses! Data Pengguna Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();

        if (Auth::user()->role === 'super_admin') {
            return view('pages.admin.user.index', [
                'user' => $user
            ]);
        } elseif (Auth::user()->role === 'admin') {
            return view('pages.staff.user-staff.index', [
                'user' => $user
            ]);
        }
    }

    public function edit($id)
    {
        $item = User::findOrFail($id);

        if (Auth::user()->role === 'super_admin') {
            return view('pages.admin.user.edit', [
                'item' => $item
            ]);
        } elseif (Auth::user()->role === 'admin') {
            return view('pages.staff.user-staff.edit', [
                'item' => $item
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns',
            'role' => 'required|in:' . implode(',', [User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN, User::ROLE_USER]),
        ]);

        $item = User::findOrFail($id);

        $redirect = Auth::user()->role === 'super_admin' ? 'user.index' : 'user-staff.index';

        $item->update($validatedData);

        return redirect()
            ->route($redirect)
            ->with('success', 'Sukses! Data Pengguna telah diperbarui');
    }

    public function destroy($id)
    {
        $item = User::findorFail($id);

        Storage::delete($item->profile);

        $redirect = Auth::user()->role === 'super_admin' ? 'user.index' : 'user-staff.index';

        $item->delete();

        return redirect()
            ->route($redirect)
            ->with('success', 'Sukses! Data Pengguna telah dihapus');
    }

    public function upload_profile(Request $request)
    {
        $validatedData = $request->validate([
            'profile' => 'required|image|file|max:1024',
        ]);

        $id = $request->id;
        $item = User::findOrFail($id);

        //dd($item);

        if ($request->file('profile')) {
            Storage::delete($item->profile);
            $item->profile = $request->file('profile')->store('assets/profile-images');
        }

        $redirect = Auth::user()->role === 'super_admin' ? 'user.index' : 'user-staff.index';

        $item->save();

        return redirect()
            ->route($redirect)
            ->with('success', 'Sukses! Photo Pengguna telah diperbarui');
    }

    public function change_password()
    {
        if (Auth::user()->role === 'super_admin') {
            return view('pages.admin.user.change-password');
        } elseif (Auth::user()->role === 'admin') {
            return view('pages.staff.user-staff.change-password');
        }
    }
}

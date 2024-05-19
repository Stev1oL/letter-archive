<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (Auth::user()->role === 'super_admin') {
            return view('pages.admin.user.profile', [
                'user' => $user
            ]);
        } elseif (Auth::user()->role === 'admin') {
            return view('pages.staff.user.profile', [
                'user' => $user
            ]);
        } elseif (Auth::user()->role === 'user') {
            return view('pages.user.user.profile', [
                'user' => $user
            ]);
        }
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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

        $redirect = Auth::user()->role === 'super_admin' ? 'user.index' : (Auth::user()->role === 'admin' ? 'user-staff.index' : 'user-user.index');

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
            return view('pages.staff.user.change-password');
        } elseif (Auth::user()->role === 'user') {
            return view('pages.user.user.change-password');
        }
    }

    public function update_password(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['min:5', 'max:255'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

        $redirect = Auth::user()->role === 'super_admin' ? 'change-password' : (Auth::user()->role === 'admin' ? 'change-password-staff' : 'change-password-user');

        return redirect()
            ->route($redirect)
            ->with('success', 'Sukses! Password telah diperbarui');
    }
}

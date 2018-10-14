<?php

namespace App\Http\Controllers;

use App\Enums\UserType;
use App\Http\Requests\UserRequest;
use App\Renewal;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', Auth::user());

        $users = User::get();

        if(request()->wantsJson() || request()->expectsJson()) {
            return DataTables::of($users)->addColumn('actions', function($user){
                return implode("", [
                    '<a href="' . route('users.edit', $user) . '" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-edit"></i></a>',
                    '<a href="' . route('users.destroy', $user) . '" class="deleteDataTableRecord btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-trash"></i></a>',
                ]);
            })->editColumn('role', function ($user) {
                return UserType::getDescription($user->role);
            })->rawColumns(['actions'])->make(true);
        }

        return view('users.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Auth::user());

        return view('users.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $request->merge(['password' => Hash::make($request->password)]);
        User::create($request->validated());

        return redirect()->route('users.index')
            ->with('status', 'User creato con successo');;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('view', $user);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $user->update($request->validated());

        $redirect = (Auth::user()->id == $user->id && !$user->isAdmin()) ? 'dashboard' : 'users.index';

        return redirect()->route($redirect)
            ->with('status', 'User aggiornato con successo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        if(request()->wantsJson() || request()->expectsJson()) {
            $redirect = (Auth::user() == $user) ? route('login') : route('users.index');
            $user->delete();
            return [
                'redirect' => $redirect,
                'message' => 'User eliminato con successo'
            ];
        }

        if(Auth::user() == $user){
            $user->delete();
            return redirect()->route('login');
        }
    }

    public function destroyAll(Request $request)
    {
        $this->authorize('massiveDelete', Auth::user());

        $ids = explode(",",$request->ids);
        $redirect = (in_array(Auth::user()->id, $ids)) ? route('login') : '';

        User::whereIn('id',$ids)->delete();

        return [
            'redirect' => $redirect,
            'message' => 'Utenti eliminati con successo'
        ];
    }
}

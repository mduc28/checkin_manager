<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(Request $request)
    {
        $aryUser = User::filter($request->all())->paginate(config('handle.paginate'));
        $aryUser->appends($request->query());
        $aryRole = Role::all();

        return view('admin.user.list', compact('aryUser', 'aryRole'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        $aryRole = Role::all();

        return view('admin.user.create', compact('aryRole'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'role_id'  => $request->role,
                'password' => bcrypt($request->password)
            ]);

            $request->role == config('handle.role.admin') ? $user->assignRole('admin') : $user->assignRole('staff');

            DB::commit();

            return response()->json(['message' => 'Created successfully'], config('handle.http_code.success'));
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return response()->json(['message' => 'Created Failed'], config('handle.http_code.error'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit($id)
    {
        $user    = User::findOrFail($id);
        $aryRole = Role::all();

        return view('admin.user.edit', compact('user', 'aryRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request)
    {
        try {
            DB::beginTransaction();
            User::findOrFail($request->id)->update(
                [
                    'name'    => $request->name,
                    'phone'   => $request->phone,
                    'email'   => $request->email,
                    'role_id' => $request->role,
                ]);
            DB::commit();

            return response()->json(['message' => 'Update successfully'], config('handle.http_code.success'));
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return response()->json(['message' => 'Update Failed'], config('handle.http_code.error'));
        }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        try {
            User::findOrFail($request->id)->delete();

            return response()->json(['message' => 'Delete successfully'], config('handle.http_code.success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => 'Delete failed'], config('handle.http_code.error'));
        }

        
    }

    /**
     * Show change-password form
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function changePasswordForm()
    {
        return view('admin.login.change_password');
    }

    /**
     * Handle changepassword feature
     *
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'The current password is incorrect'],
                config('handle.http_code.error'));
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Change password successfully', 'route' => route('login.index')],
            config('handle.http_code.success'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * check Auth
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->role_id == config('handle.role.admin')) {
                return redirect()->route('dashboard');
            }

            return redirect()->route('check_in.create');
        } else {
            return redirect()->route('login.index');
        }
    }

    /**
     * Process login
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $remember = $request->remember == config('handle.remember_token.checked') ? true : false;

        $login = [
            'email'    => $request->email,
            'password' => $request->password,
        ];
        if (Auth::attempt($login, $remember)) {
            $user = Auth::user();
            if ($user->first_login == config('handle.first_login.true')) {
                return response()->json(route('change.pass.first.index'), config('handle.http_code.success'));
            }

            return response()->json(route('login.index'), config('handle.http_code.success'));
        } else {
            return response()->json(['message' => 'Your email or password is incorrect!'],
                config('handle.http_code.error'));
        }
    }

    /**
     * Process the log out
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->back();
    }

    /**
     * Show force change-password form
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function changePassFirstForm()
    {
        return view('admin.login.change_password');
    }

    /**
     * Handle force change-password feature
     *
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassFirst(ChangePasswordRequest $request)
    {
        $user = Auth::user();

        if ($user) {
            $user->update([
                'password'    => bcrypt($request->password),
                'first_login' => config('handle.first_login.false'),
            ]);

            return response()->json(['message' => 'Change password successfully', 'route' => route('login.index')],
                config('handle.http_code.success'));
        }

        return response()->json(['message' => 'Cannot change. Please retype your password.'],
            config('handle.http_code.error'));
    }
}

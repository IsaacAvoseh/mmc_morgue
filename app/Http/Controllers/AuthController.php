<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        // dd($request->all());
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        if ($request->isMethod('POST')) {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);
            
            if (Auth::attempt($credentials)) {
                if (Auth::user()->type == 'none') {
                    Auth::logout();
                    return back()->withErrors('Login failed, please contact the admin');
                }
                $request->session()->regenerate();
                session()->put('user',Auth::user());
                session()->put('user_type',Auth::user()->type);
                return redirect()->intended('admin/dashboard');
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }
        return view('auth.login');
    }

    public function register(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        if ($request->isMethod('POST')) {
            return back()->with(['error' => 'Error!, Please Contact the Admin']);
            $request->validate(
                [
                    'name' => 'required|string',
                    'email' => 'required|string|email|unique:users',
                    'password' => 'required|string|min:6|confirmed',
                ],
                [
                    'name.required' => 'Enter your full name',
                    'email.required' => 'Enter your email',
                ]
            );

            try {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->type = $request->type;
                $user->password = Hash::make($request->password);
                // dd($user);
                $user->save();
                Auth::loginUsingId($user->id);
                return redirect()->route("apply")->withSuccess('Login details saved, please continue by filling the form');
            } catch (\Exception $e) {
                return back()->withErrors('An error occurred');
            }
        }
        return view('auth.register');
    }

    public function users(Request $request)
    {
        if ($request->isMethod('POST')) {

            $request->validate(
                [
                    'name' => 'required|string',
                    'email' => 'required|string|email|unique:users',
                    'password' => 'required|string|min:6|confirmed',
                ],
                [
                    'name.required' => 'Enter your full name',
                    'email.required' => 'Enter your email',
                ]
            );

            if (auth()->user()->type != 'admin') {
                return back()->with(['error' => 'You are not authorized to perform this action.'], 403);
            }

            try {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->type = $request->type;
                $user->password = Hash::make($request->password);
                // dd($user);
                $user->save();
                return back()->with(['success' => 'User Created Successfully']);
            } catch (\Exception $e) {
                return back()->withErrors('An error occurred');
            }
        }
        return view('users.users', [
            'users' => User::latest()->paginate(50)
        ]);
    }

    public function delete_user(Request $request)
    {
        // return json response
        if ($request->id) {
            try {
                if ($request->id == auth()->user()->id) {
                    return response()->json(['error' => 'Sorry, you cannot delete yourself sir/ma.'], 400);
                }
                if (auth()->user()->type != 'admin') {
                    return response()->json(['error' => 'You are not authorized to perform this action.'], 403);
                }
                $staff = User::find($request->id);
                $staff->delete();
                return response()->json(['success' => 'User deleted successfully'], 200);
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Something went wrong.'], 500);
            }
        } else {
            return response()->json(['error' => 'Error deleting staff'], 500);
        }
    }

    public function get_user(Request $request)
    {
        // return json response
        if ($request->id) {
            try {
                $staff = User::find($request->id);
                // delay for 0.5 seconds
                sleep(0.5);
                return response()->json(['success' => 'User fetched successfully', 'data' => $staff], 200);
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Error fetching user'], 500);
            }
        } else {
            return response()->json(['error' => 'Error fetching user'], 500);
        }
    }

    public function update_user(Request $request)
    {
        // return json response
        if ($request->id) {
            if (auth()->user()->type != 'admin') {
                return response()->json(['error' => 'You are not authorized to perform this action.'], 403);
            }
            if ($request->id == auth()->user()->id && $request->type != 'admin') {
                return response()->json(['error' => 'Sorry, you cannot change your own type'], 400);
            }
            try {
                // dd($request->all());
                $user = User::find($request->id);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->type = $request->type;
                $user->save();
                return response()->json(['success' => 'User updated successfully'], 200);
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Error updating user'], 500);
            }
        } else {
            return response()->json(['error' => 'Error updating user'], 500);
        }
    }
    public function update_password(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if (auth()->user()->type != 'admin') {
            return response()->json(['error' => 'You are not authorized to perform this action.'], 403);
        }
        try {
            $user =  User::find($request->id);
            if ($user) {
                $user->update([
                    'password' => Hash::make($request->password)
                ]);
                return response()->json(['success' => 'Password Updated !.'], 200);
            } else {
                return response()->json(['error' => 'User not found.'], 404);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }


    public function switch_user(Request $request){
        // change user_type in session and return json response
        if($request->user_type){
            session()->put('user_type',$request->user_type);
            return response()->json(['message' => 'User Type changed successfully'], 200);
        }else{
            return response()->json(['message' => 'Error changing user type'], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

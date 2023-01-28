<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Log;
use \App\Models\Role;
use \App\Models\User;
use DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Request $request)
    {
        if (!Auth::check()) {
            return view('login');
        }

        $roles = Role::all();

        return view('user', compact('roles'));
    }

        /**
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return view('login');
        }

        $request->validate([
            'userName' => 'unique:users,name',
        ]);

        $user = new User();
        $user->create([
            // 'role_id' => $request->userRole,
            'role_id' => $request->newCreateroleType,
            'name' => $request->userName,
            'email' => $request->userEmail,
            'password' => Hash::make($request->userPassword),
        ]);

        return redirect()->route('user.list')->with(['message' => '新規アカウントを作成しました']);
    }

    /**
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function list()
    {
        try {
            $roles = Role::all();
            $users = DB::table('users')
                        ->select('users.*', 'roles.name as role_name')
                        ->join('roles', 'users.role_id', '=', 'roles.id')
                        ->orderBy("users.created_at")
                        ->paginate(40);
        } catch(\Exception $e){
            Log::error($e);
            throw $e;
        }

        return view('user', compact('roles', 'users'));
    }

    /**
     * @param int $user_id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function detail(Request $request, $user_id)
    {
        if (!Auth::check()) {
            return view('login');
        }

        $roles = Role::all();
        $user = User::where('id', '=', $user_id)->first();

        return view('user', compact('roles', 'user'));
    }

    /**
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Request $request)
    {
        if (!Auth::check()) {
            return view('login');
        }

        $request->validate([
            'userName' => 'unique:users,name,'.$request->userId.',id',
        ]);

        $user = User::find($request->userId);
        if ($user) {
            try {
                // $user->role_id = $request->userRole;
                $user->name = $request->userName;
                $user->email = $request->userEmail;
                if ($request->userPassword) {
                    $user->password = Hash::make($request->userPassword);
                }
                $user->save();
            } catch(\Exception $e){
                Log::error($e);
                throw $e;
            }
        }

        return redirect()->route('user.detail', ['id' => $user->id])->with(['message' => '更新処理を完了しました']);
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function delete(Request $request)
    {
        if (!Auth::check()) {
            return view('login');
        }

        try {
            User::where('id', $request->userId)->delete();
        } catch(\Exception $e){
            Log::error($e);
            throw $e;
        }

        return redirect()->route('user.list')->with(['message' => '削除処理を完了しました']);
    }
}

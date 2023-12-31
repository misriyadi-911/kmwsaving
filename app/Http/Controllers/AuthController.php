<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAccount;
use App\Utils\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{


  public function register(Request $request) {
    
    try {

      $this->validate($request, [
        'username' => ['required', 'string', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8'],
        'name'     => ['required', 'string', 'min:6', 'max:255'],
        'gender'   => ['required', 'string', 'min:4'],
      ]);

      $user = User::create([
        'username' => $request->username,
        'password' => app('hash')->make($request->password),
        'gender'  => $request->gender,
        'name'    => $request->name,
        'role'    => $request->role ?? 'student',
      ]);
      return HttpResponse::success($user, 'Register success');
    } catch (\Throwable $th) {
      return HttpResponse::error($th->getMessage());
    }
  }

  public function login()
  {
    try {
      $this->validate(request(), [
        'email' => ['required', 'string', 'max:255'],
        'password' => ['required', 'string', 'min:8'],
      ]);


      $credentials = request()->only(['email', 'password']);
      if (!$token = Auth::attempt($credentials)) {
        return HttpResponse::error('Unauthorized', 401);
      }
      return $this->respondWithToken($token);
    } catch (\Throwable $th) {
      return HttpResponse::error($th->getMessage());
    }
  }

  public function getMe()
  {
    $me = auth()->user();
    if($me->type == 'admin') {
      $exist = UserAccount::leftjoin('admin', 'user_account.user_account_id', '=', 'admin.user_account_id')->where('user_account.user_account_id', $me->user_account_id)->first();
    } else {
      $exist = UserAccount::leftjoin('pilgrims', 'user_account.user_account_id', '=', 'pilgrims.user_account_id')->where('user_account.user_account_id', $me->user_account_id)->first();
    }
    // dd($exist);
    return HttpResponse::success($exist, 'Get user success');
  }

  public function logout()
  {
    auth()->logout();
    return HttpResponse::success([], 'Logout success');
  }

  public function refresh()
  {
    return $this->respondWithToken(auth()->refresh(), 'Refresh token success');
  }

  private function respondWithToken($token, $message = 'Login success')
  {
    return HttpResponse::success([
      'token_type' => 'bearer',
      'expires_in' => auth()->factory()->getTTL() . " minutes",
      'token' => $token
    ], $message);
  }

}
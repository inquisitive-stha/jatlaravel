<?php

namespace Modules\JatAuth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\JatAuth\Http\Requests\JatAuthLoginRequest;

class JatAuthController extends Controller
{
    use ApiResponses;

    public function login(JatAuthLoginRequest $request)
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return $this->error('Invalid Credentials.', 401);
        }

        $user = User::where('email', $request->email)->first();

        return $this->ok('User Logged In Successfully', [
            'token' => $user->createToken(
                'API Token from ' . $user->email,
                ['*'],
                now()->addDays(7)
            )->plainTextToken
        ]);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return $this->ok('User Logged Out Successfully');
    }
}

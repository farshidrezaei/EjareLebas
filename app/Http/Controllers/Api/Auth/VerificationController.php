<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\UserRequestedVerificationEmail;
use App\User;
use App\VerificationToken;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;

class VerificationController extends Controller
{

    public function verify(VerificationToken $token)
    {

        $token->user()->update([
            'is_active' => true
        ]);

        $token->delete();

        // Uncomment the following lines if you want to login the user
        // directly upon email verification
        // Auth::login($token->user);
        // return redirect('/home');

        return redirect(route('auth.verified'));

    }

    public function resend(Request $request)
    {
        $deCryptRequest = $this->getParams($request->params);
        $user = User::whereEmail($deCryptRequest['email'])->firstOrFail();

        if ($user->is_active) {
            return response()->json([
                'result' => 'error',
                'message' => 'شما قبلا حساب خود را فعال کرده اید.'
            ],
                $this->userNotFoundStatus);
        }

        event(new UserRequestedVerificationEmail($user));

        return response()->json([
            'result' => 'ok',
            'message' => 'لینک فعال سازی مجددا به ایمیل شما ارسال شد.'
        ],
            $this->successStatus);
    }


}

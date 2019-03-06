<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use App\VerificationToken;
use Auth;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Password;
use Validator;

class ResetPasswordController extends Controller
{

    use SendsPasswordResetEmails;

    public function email(Request $request)
    {
        $deCryptRequest = $this->getParams($request->params);

        $validator = Validator::make($deCryptRequest,
            [
                'email' => 'required|email',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'result' => 'error',
                'error' => $validator->errors()
            ], $this->validateErrorStatus);
        }

        $response = $this->broker()->sendResetLink([
            'email' => $deCryptRequest['email']
        ]);

        if ($response == Password::RESET_LINK_SENT) {
            return response()->json([
                'result' => 'ok',
                'message' => 'ایمیلی حاوی لینک تغییر رمز ورود برای شما ارسال شد.'
            ], $this->successStatus);
        }
        return response()->json([
            'result' => 'error',
            'message' => 'با ایمیل وارد شده قبلا ثبت نامی انجام نشده است.'
        ], $this->userNotFoundStatus);

    }


    public function getResetToken(Request $request)
    {
        $deCryptRequest = $this->getParams($request->params);
        $this->validate($deCryptRequest, ['email' => 'required|email']);

        if ($request->wantsJson()) {
            $user = User::where('email', $deCryptRequest['email'])->first();
            if (!$user) {
                return response()->json(Json::response(null, trans('passwords.user')), 400);
            }
            $token = $this->broker()->createToken($user);
            return response()->json(eteachCrypt(Json::response(['token' => $token])));
        }
    }
}

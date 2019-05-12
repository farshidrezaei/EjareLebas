<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use Validator;

class LoginController extends Controller
{

    public function username(): string
    {
        return 'email';
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login( Request $request )
    {
        $validator = Validator::make( $request->all(), [
            'username' => 'required',
            'password' => 'required',
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'result' => false,
                'code' => self::VALIDATE_ERR,
                'message' => 'خطای اعتبار سنجی',
                'response' => $validator->errors()
            ] );
        } else {


            if ( Auth::attempt( [
                $this->username() => $request->username,
                'password' => $request->password
            ] ) ) {
                $user = Auth::user();

                if ( empty( $user->email_verified_at ) ) {
                    Auth::logout();
                    return response()->json( [
                        'result' => false,
                        'code' => self::ACCOUNT_DISABLE_ERR,
                        'message' => 'حساب شما هنوز فعال نشده است. لطفا توسط لینکی که به ایمیل شما ارسال شد، حساب خود را فعال کنید.',
                        'response' => null
                    ] );
                }

                $user = User::findOrFail( Auth::id() );

                $data = [
                    'user' => $user,
                    'token' => $user->createToken( 'EjareLebas' )->accessToken,
                    'check' => true
                ];
                return response()->json( [
                    'result' => true,
                    'code' => self::SUCCESS,
                    'message' => 'احراز هویت با موفقیت انجام شد.',
                    'response' => $data
                ] );
            } else {
                return response()->json( [
                    'result' => false,
                    'code' => self::VERIFICATION_ERR,
                    'message' => 'نام کاربری یا رمز عبور وارد شده اشتباه است.',
                    'response' => null
                ] );

            }
        }
    }


    public function logout()
    {
        if ( $user = Auth::guard( 'api' )->user() ) {
            $user->token()->revoke();
            $user->token()->delete();
            $data = [
                'check' => false,
                'user' => null,
                'token' => ''
            ];
            return response()->json( [
                'result' => true,
                'message' => 'شما از برنامه خارج شدید.',
                'response' => $data
            ] );
        } else {
            return response()->json( [
                'result' => false,
                'message' => 'شما قبلا از حساب خود خارج شده اید.',
                'response' => null
            ] );
        }

    }

}

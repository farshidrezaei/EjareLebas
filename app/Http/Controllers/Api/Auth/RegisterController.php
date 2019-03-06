<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;

class RegisterController extends Controller
{


    public function register( Request $request )
    {

        $deCryptRequest = $this->getParams( $request->params );

        $validator = Validator::make( $deCryptRequest, [

            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ] );
        if ( $validator->fails() ) {
            return response()->json( [
                'result' => 'error',
                'error' => $validator->errors()
            ],
                $this->validateErrorStatus );
        }

        $user = User::create( [
            'username' => $deCryptRequest[ 'email' ],
            'email' => $deCryptRequest[ 'email' ],
            'password' => $deCryptRequest[ 'password' ],
        ] );


        return response()->json( [
            'result' => 'ok',
            'message' => 'ثبت نام شما با موفقیت انجام شد. برای فعال سازی حسابتان ایمیلی حاوی لینک فعال سازی برای شما ارسال شد.'
        ],
            $this->successStatus );
    }

}

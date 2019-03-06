<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use Psy\Util\Json;
use Validator;

class oAuthLoginController extends Controller
{

    public function username(): string
    {
        return 'email';
    }


    public function login( Request $request )
    {

        $deCryptRequest = json_decode( eteachDeCrypt( $request->params ), true );

        if ( ! $deCryptRequest ) {
            return response()->json( [
                'result' => 'error',
                'message' => 'خطا در اطلاعات ورودی',

            ],
                $this->incompleteInputsStatus );
        }

        $user = User::whereEmail( $deCryptRequest[ 'email' ] )->first();

        if ( $user ) {
            if ( Auth::loginUsingId( $user->id ) ) {
                if ( ! $user->is_enable ) {
                    return response()->json( [
                        'result' => 'error',
                        'message' => 'حساب شما توسط مدیریت، غیرفعال شده است.'
                    ],
                        $this->accountBlockedStatus );
                }

                $user = User::findOrFail( Auth::id(), [ 'id', 'name', 'family', 'country_id' ] );
                if ( ! empty( $user->country ) ) {
                    $user->country_name = $user->country->title;
                } else {
                    $user->country_name = "";
                }
                $data = [
                    'user' => $user,
                    'token' => $user->createToken( 'eTeach' )->accessToken,
                ];
                return response()->json( [
                    'result' => 'ok',
                    'data' => eteachCrypt( json_encode( $data ) ),
                    'register' => false
                ],
                    $this->successStatus );
            }
            return response()->json( [
                'result' => 'error',
                'message' => 'خطا در ورود'

            ],
                $this->forbiddenStatus );
        } else {
            $validator = Validator::make( $deCryptRequest, [
                'name' => 'max:128',
                'family' => 'max:128',
                'email' => 'required|email|unique:users',
            ] );
            if ( $validator->fails() ) {
                return response()->json( [
                    'result' => 'error',
                    'error' => $validator->errors()
                ],
                    $this->validateErrorStatus );
            }

            $generatedPassword = 'pas' . str_random( '3' ) . 'e-teach';

            $user = User::create( [
                'name' => $deCryptRequest[ 'name' ],
                'family' => $deCryptRequest[ 'family' ],
                'gender' => $deCryptRequest[ 'gender' ] ?? 'undisclosed',
                'phone_code' => $deCryptRequest[ 'phone_code' ] ?? null,
                'mobile' => $deCryptRequest[ 'mobile' ] ?? null,
                'is_active' => true,
                'username' => $deCryptRequest[ 'email' ],
                'email' => $deCryptRequest[ 'email' ],
                'password' => $generatedPassword,
            ] );

            if ( Auth::loginUsingId( $user->id ) ) {

                $user = Auth::user();

                if ( ! $user->is_enable ) {
                    return response()->json( [
                        'result' => 'error',
                        'message' => 'حساب شما توسط مدیریت، غیرفعال شده است.'
                    ],
                        $this->accountBlockedStatus );
                }

                $user = User::findOrFail( Auth::id(), [ 'id', 'name', 'family', 'country_id' ] );
                if ( ! empty( $user->country ) ) {
                    $user->country_name = $user->country->title;
                } else {
                    $user->country_name = "";
                }

                $data = [
                    'user' => $user,
                    'token' => $user->createToken( 'eTeach' )->accessToken,
                ];
                return response()->json( [
                    'result' => 'ok',
                    'data' => eteachCrypt( json_encode( $data ) ),
                    'register' => true
                ],
                    $this->successStatus );
            }

            return response()->json( [
                'result' => 'error',
                'message' => 'خطا در ورود'

            ],
                $this->forbiddenStatus );
        }
    }

    public function update( Request $request )
    {


        $deCryptRequest = json_decode( eteachDeCrypt( $request->params ), true );

        $validator = Validator::make( $deCryptRequest, [
            'password' => 'required|confirmed',
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'result' => 'error',
                'error' => $validator->errors()
            ], $this->validateErrorStatus );
        }

        $user = Auth::guard( 'api' )->user();

        $user->update( [
            'password' => $deCryptRequest[ 'password' ]
        ] );

        return response()->json( [
            'result' => 'ok',
            'message' => 'رمزعبور با موفقیت ثبت شد.'
        ],
            $this->successStatus );
    }


}

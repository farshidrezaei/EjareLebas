<?php

namespace App\Http\Controllers\Admin\User;

use App\Clothing;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Validator;

class UserController extends Controller
{

    public function index()
    {
        $items = User::query()->oldest()->get();

        $items->each( function ( $item ) {
            $item->created_at_fa = $item->created_at_jalali;
            $item->secured = false;
            if ( $this->isSuperAdmin( $item->id ) ) {
                $item->secured = true;
            }

        } );


        return response()->json( [
            'result' => true,
            'response' => $items
        ], 200 );
    }

    public function show( $id )
    {

        $item = User::with( 'roles' )->findOrFail( $id );
        $item->created_at_fa = $item->created_at_jalali;
        $item->gender_farsi = $item->gender_fa;
        return response()->json( [
            'result' => true,
            'response' => $item
        ] );
    }

    public function store( Request $request )
    {


        $validator = Validator::make( $request->all(), [
            'avatar' => 'required',
            'first_name' => 'required|string|max:128',
            'last_name' => 'required|string|max:128',
            'gender' => 'required|string|max:128',
            'national_code' => 'string|max:10',
            'mobile' => 'required|max:16',
            'email' => 'required|email|max:128|unique:users',
            'password' => 'required|min:6|confirmed',
            'roles' => [
//                'required',
                'array'
            ],
        ] );
        if ( $validator->fails() ) {
            return response()->json( [
                'result' => false,
                'message' => 'خطا در اعتبار سنجی',
                'response' => $validator->messages()
            ] );
        } else {

            $user = User::create( $request->except( [ 'password_confirmation', 'roles' ] ) );


            $user->attachRoles( $request[ 'roles' ] );

            return response()->json( [
                'result' => true,
                'کاربر با موفقیت اضافه شد.',
                'response' => $user
            ] );
        }

    }

    public function update( Request $request, $id )
    {

        $rules = [
            'first_name' => 'required|string|max:128',
            'last_name' => 'required|string|max:128',
            'gender' => 'required|string|max:128',
            'national_code' => 'string|max:10',
            'mobile' => 'required|max:16',
            'email' => 'required|string|email|max:128|unique:users,email,' . $id,
            'roles' => 'array',
        ];
        if ( ! empty( $request->password ) ) {
            $rules[ 'password' ] = 'nullable|min:6|confirmed';
        }

        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( [
                'result' => false,
                'message' => 'خطا در اعتبار سنجی',
                'response' => $validator->messages()
            ] );
        } else {

            $user = User::findOrFail( $id );
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->gender = $request->gender;
            $user->national_code = $request->national_code;
            $user->mobile = $request->mobile;
            $user->address = $request->address;
            $user->biography = $request->biography;
            $user->email = $request->email;
            $user->x = $request->x;
            $user->y = $request->y;
            $user->avatar = $request->avatar;
            if ( ! empty( $request->password ) ) $user->password = $request->password;

            $user->save();


//            $user->$user->syncRoles( $request[ 'roles' ] );

            return response()->json( [
                'result' => true,
                'کاربر با موفقیت ویرایش شد.',
                'response' => $user
            ] );
        }

    }

    public function destroy( Request $request )
    {
        $ids = collect( $request[ 'ids' ] );
        $ids = $ids->pluck( 'id' );

        if ( $this->preventUserToDeleteSuperAdmins( $ids ) )
            return response()->json( [
                'result' => false,
                'message' => "شما اجازه حذف کاربر های انتخاب شده را ندارید."
            ] );

        try {
            User::whereIn( 'id', $ids )->delete();
            return response()->json( [
                'result' => true,
                'message' => "کاربرهای انتخاب شده با موفقیت حذف شدند."
            ] );
        } catch ( \Exception $e ) {
            return response()->json( [
                'result' => false,
                'message' => "در حذف کاربر های انتخاب شده، خطایی رخ داده است."
            ] );
        }
    }

    private function preventUserToDeleteSuperAdmins( Collection $ids ): bool
    {
        $super_admin_ids = [ 1 ];

        foreach ( $super_admin_ids as $item ) {
            if ( $ids->contains( $item ) ) {
                return true;
            }
        }

        return false;
    }

    private function isSuperAdmin( int $id ): bool
    {
        $super_admin_ids = [ 1 ];
        if ( in_array( $id, $super_admin_ids ) ) return true;
        else return false;

    }

    public function avatarUpload( Request $request )
    {
        $avatar = $request->file( 'avatar' );

        $avatar_name = 'avatar.' . $avatar->getClientOriginalExtension();

        $avatar_path = "/images/$request->user/avatar/";


        $avatar->move( public_path() . $avatar_path, $avatar_name );

        return response()->json( $avatar_path . $avatar_name );

    }

    public function clothes( $user_id )
    {
        $clothes = Clothing::query()->with( [ 'category' ] )->whereUserId( $user_id )->get();
        $clothes->each( function ( $item ) {
            $item->confirmation_status_farsi = $item->confirmation_status_fa;
        } );

        return response()->json( [
            'result' => true,
            'response' => $clothes
        ] );

    }
}

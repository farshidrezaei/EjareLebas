<?php

namespace App\Http\Controllers\Admin\Role;

use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class RoleController extends Controller
{
    public function index()
    {
        $items = Role::query()
            ->select( [
                'id',
                'name',
                'display_name',
                'description',
                'created_at'
            ] )
            ->with( 'permissions:id,display_name,group' )
            ->get();

        $items->each( function ( $item ) {
            $item->created_at_fa = $item->created_at_jalali;
        } );

        return response()->json( [
            'result' => true,
            'message' => '',
            'response' => $items
        ] );

    }


    public function store( Request $request )
    {
        $this->validate( $request, $this->validator( $request ) );

        $role = new Role();
        $role->name = $request[ 'name' ];
        $role->display_name = $request[ 'display_name' ];
        $role->description = $request[ 'description' ];
        $role->save();

        $role->attachPermissions( $request[ 'permissions' ] );

        return response()->json( [
            'result' => true,
            'message' => 'نقش با موفقیت افزوده شد',
            'response' => $role
        ] );
    }

    public function show( $id )
    {
        $role = Role::with( 'permissions:id,display_name,group' )->findOrFail( $id );
        return response()->json( [
            'result' => true,
            'message' => '',
            'response' => $role
        ] );
    }


    public function update( Request $request, $id )
    {
        $role = Role::findOrFail( $id );

        if ( $this->preventEditSuperRoles( $role ) )
            return response()->json( [
                'result' => false,
                'message' => 'شما دسترسی ویرایش این نقش را ندارید',
                'response' => null
            ] );

        $this->validate( $request, $this->validator( $request, $role ) );

        $role->name = $request[ 'name' ];
        $role->display_name = $request[ 'display_name' ];
        $role->description = $request[ 'description' ];
        $role->save();

        $role->syncPermissions( $request[ 'permissions' ] );

        return response()->json( [
            'result' => true,
            'message' => 'نقش جدید با موفقیت ایجاد گردید',
            'response' => $role
        ] );
    }


    public function destroy( Request $request )
    {
        $ids = collect( $request[ 'ids' ] );
        $ids = $ids->pluck( 'id' );
        if ( $this->preventUserToDeleteSuperAdminRoles( $ids ) )
            return response()->json( [
                'result' => false,
                'message' => "شما دسترسی حذف این نقش را ندارید"
            ] );

        try {
            Role::whereIn( 'id', $ids )->delete();
            return response()->json( [
                'result' => true,
                'message' => "لباس های انتخاب شده با موفقیت حذف شدند."
            ] );
        } catch ( \Exception $e ) {
            return response()->json( [
                'result' => false,
                'message' => "در حذف لباس های انتخاب شده، خطایی رخ داده است."
            ] );
        }
    }

    /**
     * @param Request   $request
     * @param Role|null $role
     *
     * @return array
     */
    private function validator( Request $request, Role $role = null )
    {
        $rules = [
            'name' => 'required|unique:roles|regex:/(^[A-Za-z-_ ]+$)+/',
            'display_name' => 'required',
            'description' => 'required'
        ];

        if ( $request->method() === 'PUT' )
            $rules[ 'name' ] = 'required|regex:/(^[A-Za-z-_ ]+$)+/|unique:roles,name,' . $role->id;

        return $rules;
    }

    /**
     * @param array $ids
     *
     * @return bool
     */
    private function preventUserToDeleteSuperAdminRoles( Collection $ids )
    {
        $super_admin_ids = [ 1, 2, 3, 4 ];

        foreach ( $super_admin_ids as $item ) {
            if ( in_array( $item, $ids ) )
                return true;
        }

        return false;
    }

    /**
     * Prevent users to manipulate super roles
     *
     * @param Role $role
     *
     * @return bool
     */
    private function preventEditSuperRoles( Role $role )
    {
        if ( in_array( $role->id, [ 1, 2, 3, 4 ] ) )
            return true;

        return false;
    }
}

<?php

namespace App\Http\Controllers\Admin\Permission;

use App\Permission;
use App\PermissionTitle;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if ( $this->preventEditSuperUsersPermission( $user ) )
            return response()->json( [
                'result' => false,
                'message' => 'شما اجازه ویرایش دسترسی این کاربر را ندارید',
                'response' => null
            ] );

        $user->syncPermissions($request->permissions);

        return response()->json( [
            'result' => false,
            'message' => 'دسترسی کاربر با موفقیت ویرایش گردید.',
            'response' => null
        ] );
    }

    /**
     * Prevent users to manipulate super roles
     *
     * @param Permission $permission
     * @return bool
     */
    private function preventEditSuperUsersPermission(User $user)
    {
        if (in_array($user->id, [1, 2, 3]))
            return true;

        return false;
    }
}

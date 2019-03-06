<?php

use App\Permission;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaratrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     *
     */
    public function run()
    {
        $role = Role::create( [
            'name' => 'admin',
            'display_name' => 'ادمین',
            'description' => 'دسترسی به تمام امکانات'
        ] );

        $account = [
            'first_name' => 'فرشید',
            'last_name' => 'رضائی',
            'mobile' => '09354614194',
            'gender' => 'male',
            'national_code' => '0018363512',
            'email' => 'farshid.net1@yahoo.com',
            'password' => '123123123',
            'remember_token' => str_random( 10 ),
            'email_verified_at' => Carbon::now()
        ];


        $permissions = [
            // Panel
            [
                'name' => 'admin-panel',
                'group' => 'پنل مدیریت',
                'display_name' => 'پنل مدیریت',
                'description' => 'توانایی مشاهده پنل مدیریت',
            ],
            // File-Manager
            [
                'name' => 'file-manager',
                'group' => 'فایل',
                'display_name' => 'فایل منیجر',
                'description' => 'توانایی استفاده از فایل منیجر',
            ],


            //User
            [
                'name' => 'create-user',
                'group' => 'کاربر',
                'display_name' => 'ایجاد کاربر جدید',
                'description' => 'توانایی ایجاد کاربر جدید',
            ],
            [
                'name' => 'read-user',
                'group' => 'کاربر',
                'display_name' => 'مشاهده کاربران',
                'description' => 'توانایی مشاهده کاربران',
            ],
            [
                'name' => 'edit-user',
                'group' => 'کاربر',
                'display_name' => 'ویرایش کاربران',
                'description' => 'توانایی ویرایش کاربران',
            ],
            [
                'name' => 'delete-user',
                'group' => 'کاربر',
                'display_name' => 'حذف کاربران',
                'description' => 'توانایی حذف کاربران',
            ],


            //Role
            [
                'name' => 'create-acl',
                'group' => 'نقش و دسترسی',
                'display_name' => 'ایجاد نقش و دسترسی جدید',
                'description' => 'توانایی ایجاد نقش و دسترسی جدید',
            ],
            [
                'name' => 'read-acl',
                'group' => 'نقش و دسترسی',
                'display_name' => 'مشاهده نقش ها و دسترسی ها',
                'description' => 'توانایی مشاهده نقش ها و دسترسی ها',
            ],
            [
                'name' => 'edit-acl',
                'group' => 'نقش و دسترسی',
                'display_name' => 'ویرایش نقش ها و دسترسی ها',
                'description' => 'توانایی ویرایش نقش ها و دسترسی ها',
            ],
            [
                'name' => 'delete-acl',
                'group' => 'نقش و دسترسی',
                'display_name' => 'حذف نقش ها و دسترسی ها',
                'description' => 'توانایی حذف نقش ها و دسترسی ها',
            ],

            //Clothing
            [
                'name' => 'create-clothing',
                'group' => 'لباس',
                'display_name' => 'ایجاد لباس',
                'description' => 'توانایی ایجاد لباس',
            ],
            [
                'name' => 'read-clothing',
                'group' => 'لباس',
                'display_name' => 'مشاهده لباس',
                'description' => 'توانایی مشاهده لباس',
            ],
            [
                'name' => 'edit-clothing',
                'group' => 'لباس',
                'display_name' => 'ویرایش لباس',
                'description' => 'توانایی ویرایش لباس',
            ],
            [
                'name' => 'delete-clothing',
                'group' => 'لباس',
                'display_name' => 'حذف لباس',
                'description' => 'توانایی حذف لباس',
            ],


        ];


        foreach ( $permissions as $permission ) {
            Permission::create( $permission );
        }

        $permissions = Permission::get()->pluck( 'id' )->toArray();

        $role->attachPermissions( $permissions );

        $user = User::create( $account );

        $user->attachRole( $role->id );

        $user->attachPermissions( $permissions );
    }


    /**
     * Truncates all the laratrust tables and the users table
     *
     * @return    void
     */
    public function truncateLaratrustTables()
    {
        Schema::disableForeignKeyConstraints();
        DB::table( 'permission_role' )->truncate();
        DB::table( 'permission_user' )->truncate();
        DB::table( 'role_user' )->truncate();
        \App\User::truncate();
        \App\Role::truncate();
        \App\Permission::truncate();
        Schema::enableForeignKeyConstraints();
    }
}

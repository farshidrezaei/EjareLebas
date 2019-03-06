<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'users', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->unsignedInteger( 'city_id' )->nullable();
            $table->string( 'first_name', 128 );
            $table->string( 'last_name', 128 );
            $table->enum( 'gender', [ 'male', 'female' ] );
            $table->string( 'national_code', 10 )->nullable();
            $table->string( 'mobile', 16 );
            $table->text( 'address' )->nullable();
            $table->string( 'x', 64 )->nullable();
            $table->string( 'y', 64 )->nullable();
            $table->string( 'email', 128 )->unique();
            $table->string( 'avatar' )->nullable();
            $table->text( 'biography' )->nullable();
            $table->timestamp( 'email_verified_at' )->nullable();
            $table->string( 'password' );
            $table->rememberToken();
            $table->timestamps();


            $table->foreign( 'city_id' )
                ->references( 'id' )
                ->on( 'cities' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'users' );
    }
}

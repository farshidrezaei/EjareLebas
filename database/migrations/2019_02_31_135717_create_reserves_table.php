<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'reserves', function ( Blueprint $table ) {
            $table->increments( 'id' );

            $table->unsignedInteger( 'user_id' );
            $table->unsignedInteger( 'clothing_id' );

            $table->enum( 'status', [ 'pending', 'confirmed', 'unconfirmed' ] );


            $table->foreign( 'user_id' )
                ->references( 'id' )
                ->on( 'users' );

            $table->foreign( 'clothing_id' )
                ->references( 'id' )
                ->on( 'clothes' )
                ->onDelete( 'cascade' );

            $table->timestamp( 'start_at' )->nullable();
            $table->timestamp( 'end_at' )->nullable();

            $table->timestamps();

        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'reserves' );
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'favorites', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->unsignedInteger( 'user_id' );
            $table->unsignedInteger( 'clothing_id' );
            $table->timestamps();

            $table->foreign( 'user_id' )
                ->references( 'id' )
                ->on( 'users' );

            $table->foreign( 'clothing_id' )
                ->references( 'id' )
                ->on( 'clothes' )
                ->onDelete( 'cascade' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'favorites' );
    }
}

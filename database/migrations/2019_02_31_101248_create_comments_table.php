<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'comments', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->unsignedInteger( 'user_id' )->nullable();
            $table->unsignedInteger( 'clothing_id' );
            $table->enum( 'rate', [ 1, 2, 3, 4, 5, 6 ] );
            $table->text( 'body' );
            $table->timestamps();

            $table->foreign( 'user_id' )
                ->references( 'id' )
                ->on( 'users' )
                ->onDelete( 'set null' );

            $table->foreign( 'clothing_id' )
                ->references( 'id' )
                ->on( 'clothes' );

        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'comments' );
    }
}

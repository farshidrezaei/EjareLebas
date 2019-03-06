<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'chats', function ( Blueprint $table ) {
            $table->increments( 'id' );

            $table->unsignedInteger( 'user_id' );
            $table->unsignedInteger( 'clothing_id' );

            $table->enum( 'status', [ 'seen', 'unseen' ] );

            $table->foreign( 'user_id' )
                ->references( 'id' )
                ->on( 'users' );

            $table->foreign( 'clothing_id' )
                ->references( 'id' )
                ->on( 'clothes' )
                ->onDelete( 'cascade' );


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
        Schema::dropIfExists( 'chats' );
    }
}

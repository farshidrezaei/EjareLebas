<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClothesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'clothes', function ( Blueprint $table ) {
            $table->increments( 'id' );

            $table->unsignedInteger( 'user_id' )->nullable();
            $table->unsignedInteger( 'category_id' )->nullable();
            $table->string( 'title', 128 );
            $table->string( 'size', 128 )->nullable();
            $table->string( 'image', 256 )->nullable();
            $table->text( 'gallery' )->nullable();
            $table->text( 'description' )->nullable();

            $table->decimal( 'daily_price', 9, 2 )->nullable();
            $table->decimal( 'weekly_price', 9, 2 )->nullable();
            $table->decimal( 'monthly_price', 9, 2 )->nullable();

            $table->decimal( 'cash_collateral', 9, 2 )->nullable();
            $table->text( 'non_cash_collateral' )->nullable();

            $table->enum( 'confirmation_status', [ 'pending', 'confirmed', 'unconfirmed' ] )->default( 'pending' );
            $table->boolean( 'is_leased' )->default( false );

            $table->timestamps();

            $table->foreign( 'user_id' )
                ->references( 'id' )
                ->on( 'users' )
                ->onDelete( 'set null' );

            $table->foreign( 'category_id' )
                ->references( 'id' )
                ->on( 'categories' )
                ->onDelete( 'set null' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'clothes' );
    }
}

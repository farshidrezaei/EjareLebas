<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'cities', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->unsignedInteger( 'province_id' );
            $table->string( 'title', 128 );
            $table->timestamps();

            $table->foreign( 'province_id' )
                ->references( 'id' )
                ->on( 'provinces' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'cities' );
    }
}

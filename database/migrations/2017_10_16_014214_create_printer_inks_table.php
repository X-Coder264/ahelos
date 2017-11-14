<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrinterInksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('printer_inks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('printer_id')->unsigned()->index();
            $table->foreign('printer_id')->references('id')->on('printers')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('printer_inks');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsChecklistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts_checklist', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_dashboard_task');
            $table->integer('id_checklist_name');
            $table->integer('id_user');
            $table->text('name');
            $table->integer('done');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts_checklist');
    }
}

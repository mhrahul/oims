<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_requisitions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id');
            $table->double('quantity', 10, 2);
            $table->string('status', 10);  //open or close
            $table->integer('supplier_id'); //user_id 
            $table->integer('requiser_id'); //user_id 
            $table->string('date', 50);
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
        Schema::dropIfExists('supplier_requisitions');
    }
}

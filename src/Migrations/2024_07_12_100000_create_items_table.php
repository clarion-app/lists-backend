<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clarion_app_lists_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('item_list_id');
            $table->string('name');
            $table->timestamps();

            $table->foreign('item_list_id')->references('id')->on('clarion_app_lists_item_lists')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('clarion_app_lists_items');
    }
};

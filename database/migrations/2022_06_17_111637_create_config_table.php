<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config', function (Blueprint $table) {
            $table->id();
            $table->string('ios_min_version')->default(0);
            $table->unsignedInteger('eth_mint_price')->default(0);
            $table->unsignedInteger('polygon_mint_price')->default(0);
            $table->timestamps();
        });

        \App\Models\Config::create([]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config');
    }
};

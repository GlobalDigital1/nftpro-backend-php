<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('token_id', function (Blueprint $table) {
            $table->string('blockchain')->nullable();
        });

        \App\Models\TokenId::create([
            'blockchain' => \App\Enums\NftBlockchain::eth()
        ]);

        \App\Models\TokenId::create([
            'blockchain' => \App\Enums\NftBlockchain::polygon()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('token_id', function (Blueprint $table) {
            $table->dropColumn('blockchain');
        });
    }
};

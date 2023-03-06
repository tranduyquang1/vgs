<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key_value');
            $table->text('value');
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });

        $initData = [
            [
                'key_value' => 'setting-email',
                'value' => '{}',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key_value' => 'setting-main',
                'value' => '{}',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key_value' => 'setting-social',
                'value' => '{}',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key_value' => 'setting-seo',
                'value' => '{}',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        \Illuminate\Support\Facades\DB::table('settings')->insert($initData);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}

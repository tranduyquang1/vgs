<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('type')->default('link');
            $table->tinyInteger('status')->default(1);
            $table->string('link', 500)->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('post_id')->nullable();
            $table->nestedSet();
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });

        $initData = [
            'name' => 'Root',
            'parent_id' => null,
            '_lft' => 1,
            '_rgt' => 2,
        ];
        \Illuminate\Support\Facades\DB::table('menus')->insert($initData);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}

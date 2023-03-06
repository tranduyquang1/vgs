 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTournamentSchelduleLive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournament_scheldule_live', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('tournament_categories_id')->nullable()->default(0);
            $table->string('date')->nullable()->default(null);
            $table->string('time')->nullable()->default(null);
            $table->string('activities')->nullable()->default(null);
            $table->tinyInteger('language')->nullable()->default(0);
            $table->integer('order')->nullable()->default(0);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('tournament_scheldule_live', function (Blueprint $table) {
            
        });
    }
}

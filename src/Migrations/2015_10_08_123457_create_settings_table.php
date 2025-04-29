<?php



use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

    public function up()
    {
        Schema::create('ticketit_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lang')->unique()->nullable();
            $table->string('slug')->unique()->index();
            $table->string('value');
            $table->string('default');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('ticketit_settings');
    }
};

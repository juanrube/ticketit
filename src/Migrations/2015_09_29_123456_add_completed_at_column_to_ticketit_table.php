<?php



use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

    public function up()
    {
        Schema::table('ticketit', function (Blueprint $table) {
            $table->timestamp('completed_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('ticketit', function (Blueprint $table) {
            $table->dropColumn('completed_at');
        });
    }
};

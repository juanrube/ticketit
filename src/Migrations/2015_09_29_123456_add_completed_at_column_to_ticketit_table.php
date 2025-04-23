<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCompletedAtColumnToTicketitTable extends Migration
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
}

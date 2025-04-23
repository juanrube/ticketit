<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EnlargeSettingsColumns extends Migration
{

    public function up()
    {
        // make value, default columns bigger
        Schema::table('ticketit_settings', function (Blueprint $table) {
            $table->mediumText('value')->change();
            $table->mediumText('default')->change();
        });
    }

    public function down()
    {
        Schema::table('ticketit_settings', function (Blueprint $table) {
            $table->string('value')->change();
            $table->string('default')->change();
        });
    }
}

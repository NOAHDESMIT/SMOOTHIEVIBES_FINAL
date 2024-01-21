<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHealthCategoryToSmoothiesTable extends Migration
{
    public function up()
    {
        Schema::table('smoothies', function (Blueprint $table) {
            // Check if the column exists before adding it
            if (!Schema::hasColumn('smoothies', 'health_category')) {
                $table->string('health_category')->nullable()->after('name');
            }
        });
    }

    public function down()
    {
        Schema::table('smoothies', function (Blueprint $table) {
            $table->dropColumn('health_category');
        });
    }
}

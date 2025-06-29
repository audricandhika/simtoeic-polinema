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
        Schema::table('exam_result', function (Blueprint $table) {
            $table->string('name')->nullable()->after('user_id');
            $table->string('nim')->nullable()->after('name');

            // Add index for better performance
            $table->index('nim');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_result', function (Blueprint $table) {
            if (Schema::hasColumn('exam_result', 'nim')) {
                $table->dropIndex(['nim']);
                $table->dropColumn(['name', 'nim']);
            }
        });
    }
};

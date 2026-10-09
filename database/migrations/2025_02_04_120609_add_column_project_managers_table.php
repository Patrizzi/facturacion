<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnProjectManagersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('project_managers', function (Blueprint $table) {
            $table->dropForeign(['project_service_id']);
            $table->dropColumn('project_service_id');

            $table->foreignId('service_id')->nullable()->constrained('servicios')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('project_managers', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropColumn('service_id');

            $table->foreignId('project_service_id')->nullable()->constrained()->nullOnDelete();
        });
    }
}

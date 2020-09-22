<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNovaRedirectTester extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table `nova_redirect_tester_groups`
        Schema::create('nova_redirect_tester_groups', function (Blueprint $table) {
            $table->id();
            $table->string("name", 50);
            $table->text("description")->nullable(true);
            $table->timestamp('updated_at')->useCurrent();
            $table->timestamp('created_at')->useCurrent();
        });

        // Add default group to the groups
        \Illuminate\Support\Facades\DB::statement("INSERT INTO `nova_redirect_tester_groups` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES (NULL, 'Default', 'This is the default group', NOW(), NULL);");

        // Create table `nova_redirect_tester`
        Schema::create('nova_redirect_tester', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nova_redirect_tester_group_id')->constrained();
            $table->string("url_from", 255);
            $table->string("url_to", 255)->nullable(true);
            $table->smallInteger("expected_status_code", false, true)->default(301);
            $table->timestamp('updated_at')->useCurrent();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nova_redirect_tester');
        Schema::dropIfExists('nova_redirect_tester_groups');
    }
}

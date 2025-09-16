<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('scoring_rule_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('scoring_rule_id');
            $table->foreign('scoring_rule_id')->references('id')->on('scoring_rules');
            $table->string('activity_name')->nullable();
            $table->integer('points');
            $table->timestamp('date_of_completion')->nullable();
            $table->string('document_file')->nullable();
            $table->string('document_text')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scoring_rule_user');
    }
};

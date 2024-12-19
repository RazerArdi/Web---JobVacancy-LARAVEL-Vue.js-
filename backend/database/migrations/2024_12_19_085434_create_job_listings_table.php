<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_job_listings_table.php

public function up()
{
    Schema::create('job_listings', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description');
        $table->string('company');
        $table->string('location');
        $table->integer('salary_min');
        $table->integer('salary_max');
        $table->string('job_type');
        $table->json('requirements');
        $table->json('skills');
        $table->date('application_deadline');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};

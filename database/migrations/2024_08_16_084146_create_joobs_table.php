<?php

use App\Models\Employer;
use App\Models\Joob;
use App\Models\User;
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
        // Schema::create('joobs', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('title');
        //     $table->text('description');
        //     $table->unsignedInteger('salary');
        //     $table->string('location');
        //     $table->string('category');
        //     $table->enum('experience', Joob::$experience);
        //     $table->foreignIdFor(Employer::class)->constrained();
        //     $table->timestamps();
        //  });


        // Önce employers tablosunu oluşturun
        Schema::create('employers', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->foreignIdFor(User::class)->nullable()->constrained();
            $table->timestamps();
        });

        // Sonra joobs tablosunu oluşturun
        Schema::create('joobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->unsignedInteger('salary');
            $table->string('location');
            $table->string('category');
            $table->enum('experience', Joob::$experience);
            $table->foreignIdFor(Employer::class)->constrained();  // Employer tablosuna referans
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Önce joobs tablosunu silin
        Schema::dropIfExists('joobs');
        // Sonra employers tablosunu silin
        Schema::dropIfExists('employers');
    }
};

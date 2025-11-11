<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Simple subjects table - NO foreign keys first
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('lecturer_id'); // Simple integer, not foreign key
            $table->timestamps();
        });

        // Simple announcements table - NO foreign keys first
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->integer('user_id'); // Simple integer, not foreign key
            $table->integer('subject_id')->nullable(); // Simple integer, not foreign key
            $table->timestamps();
        });

        // Simple assignments table - NO foreign keys first
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->integer('subject_id'); // Simple integer, not foreign key
            $table->integer('lecturer_id'); // Simple integer, not foreign key
            $table->dateTime('due_date');
            $table->integer('max_marks');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assignments');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('subjects');
    }
};
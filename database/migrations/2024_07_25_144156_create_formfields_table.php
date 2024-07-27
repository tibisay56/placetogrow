<?php

use App\Constants\FieldType;
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
        Schema::create('formfields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('forms')->onDelete('cascade');
            $table->string('field_name');
            $table->enum('field_type', FieldType::toArray());
            $table->boolean('required')->default(false);
            $table->boolean('enabled')->default(true);
            $table->text('rules')->nullable();
            $table->string('label')->nullable();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formfields');
    }
};

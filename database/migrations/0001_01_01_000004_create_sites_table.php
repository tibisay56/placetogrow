<?php

use App\Constants\CurrencyType;
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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 50)->nullable()->unique();
            $table->string('avatar')->nullable();
            $table->string('category', 100);
            $table->enum('currency', CurrencyType::toArray());
            $table->integer('payment_expiration_time')->default(1440);
            $table->foreignId('type_id')->constrained();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->json('required_fields')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};

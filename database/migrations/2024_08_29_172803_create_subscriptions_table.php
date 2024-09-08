<?php

use App\Constants\SubscriptionStatus;
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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')
                ->constrained('plans')
                ->onDelete('cascade');

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade');

            $table->string('reference')->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('email');
            $table->string('name');
            $table->string('document_number');
            $table->string('document_type');

            $table->date('start_date')->default(now())->change();
            $table->date('end_date')->nullable()->change();
            $table->enum('status', SubscriptionStatus::toArray());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};

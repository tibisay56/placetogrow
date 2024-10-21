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

            $table->foreignId('site_id')
                ->nullable()
                ->constrained('sites')
                ->onDelete('cascade');

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade');

            $table->string('reference')->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('email');
            $table->string('name');
            $table->string('surname');
            $table->string('document_number');
            $table->string('document_type');

            $table->string('token', 70)->nullable();
            $table->string('sub_token', 50)->nullable();
            $table->string('status_message', 255)->nullable();
            $table->string('request_id', 50)->nullable();

            $table->date('start_date')->default(now())->change();
            $table->date('end_date')->nullable()->change();

            $table->integer('retry_count')->default(0);
            $table->timestamp('next_retry_at')->nullable();
            $table->unsignedInteger('payment_attempts')->default(0);
            $table->date('next_billing_date')->nullable();
            $table->integer('plan_months')->default(12);
            $table->integer('months_charged')->default(0);
            $table->boolean('notified_before_charge')->default(false);
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

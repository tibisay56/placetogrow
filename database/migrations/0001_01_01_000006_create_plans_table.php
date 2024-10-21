<?php

use App\Constants\BillingFrequency;
use App\Constants\CurrencyType;
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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->unsignedBigInteger('amount');
            $table->enum('currency', CurrencyType::toArray());
            $table->enum('status', SubscriptionStatus::toArray());
            $table->integer('subscription_expiration')->nullable();
            $table->enum('billing_frequency', BillingFrequency::toArray());
            $table->foreignId('plan_type_id')->constrained();
            $table->foreignId('site_id');
            $table->foreign('site_id')->references('id')->on('sites');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};

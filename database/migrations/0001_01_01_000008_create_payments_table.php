<?php

use App\Constants\CurrencyType;
use App\Constants\PaymentGateway;
use App\Constants\PaymentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->string('description', 100);
            $table->unsignedBigInteger('amount');
            $table->enum('currency', CurrencyType::toArray());
            $table->enum('status', PaymentStatus::toArray());
            $table->enum('gateway', PaymentGateway::toArray());
            $table->unsignedInteger('process_Identifier')->nullable();

            $table->string('payer_name')->nullable();
            $table->string('payer_lastname')->nullable();
            $table->string('payer_document_type')->nullable();
            $table->string('payer_document_number')->nullable();
            $table->string('payer_email')->nullable();
            $table->json('required_fields')->nullable();

            $table->foreignId('site_id');
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');

            $table->foreignId('user_id')->nullable()->constrained('users');

            $table->unsignedBigInteger('subscription_id')->nullable();
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');
            $table->boolean('collect')->default(false);
            $table->timestamps();

            $table->unique(['reference', 'subscription_id'], 'unique_payment_reference_subscription');

            $table->dropForeign(['site_id']);
            $table->dropForeign(['subscription_id']);
            $table->dropForeign(['user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

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
            $table->string('reference')->unique();
            $table->string('description', 100);
            $table->unsignedBigInteger('amount');
            $table->enum('currency', CurrencyType::toArray());
            $table->enum('status', PaymentStatus::toArray());
            $table->enum('gateway', PaymentGateway::toArray());
            $table->unsignedInteger('process_Identifier')->nullable();

            $table->foreignId('site_id');
            $table->foreign('site_id')->references('id')->on('sites');

            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

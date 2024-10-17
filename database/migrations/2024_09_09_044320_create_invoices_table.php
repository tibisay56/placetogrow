<?php

use App\Constants\CurrencyType;
use App\Constants\InvoiceStatus;
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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 40)->unique();
            $table->unsignedBigInteger('amount');
            $table->enum('currency', CurrencyType::toArray());
            $table->string('customer_name', 100);
            $table->string('dni', 40);
            $table->string('description', 100);
            $table->integer('retry_count')->default(0);
            $table->timestamp('next_retry_at')->nullable();
            $table->unsignedInteger('payment_attempts')->default(0);
            $table->decimal('late_fee', 10, 2)->nullable();
            $table->date('due_date')->nullable();
            $table->integer('delay_days')->nullable();
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->enum('status', InvoiceStatus::toArray());
            $table->date('expired_at');
            $table->date('created_at');

            $table->foreignId('import_id')->nullable();
            $table->foreign('import_id')
                ->references('id')
                ->on('imports');

            $table->foreignId('site_id')
                ->nullable()
                ->constrained('sites')
                ->onDelete('cascade');

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('subscription_id')
                ->nullable()
                ->constrained('subscriptions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};

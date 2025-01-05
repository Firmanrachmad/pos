<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->dateTime('transaction_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('transaction_number', 20)->unique();
            $table->dateTime('due_date')->nullable();
            $table->decimal('total_amount', 15, 2);
            $table->string('payment_status', 20)->default('unpaid');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

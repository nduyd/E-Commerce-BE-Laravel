<?php

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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_method_id')->constrained('payment_methods')->cascadeOnDelete();
            $table->string('order_id')->constrained('orders')->cascadeOnDelete();
            $table->float('amount')->nullable(false);
            $table->dateTime('paid_date')->nullable(false);
            $table->string('status')->nullable(false);
            $table->string('transaction_ref')->nullable(false);
            // $table->json('metadata')->nullable();
            $table->timestamps();

            //index
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id')->unsigned();
            $table->decimal('subtotal');
            $table->decimal('total');
            $table->string('name');
            $table->enum('type', ['dine-in', 'takeaway', 'canceled'])->default('dine-in');
            $table->enum('status', ['ordered', 'delivered', 'canceled'])->default('ordered');
            $table->date('delivered_date')->nullable();
            $table->date('canceled_date')->nullable();
            $table->timestamps();
            $table->foreignId('table_id')->nullable()->constrained('tables')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

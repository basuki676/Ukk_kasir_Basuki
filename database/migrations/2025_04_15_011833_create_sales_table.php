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
                Schema::create('sales', function (Blueprint $table) {
                    $table->id();
                    $table->integer('total_price');
                    $table->integer('total_pay');
                    $table->integer('total_return');
                    $table->bigInteger('customer_id');
                    $table->bigInteger('user_id');
                    $table->Integer('poin');
                    $table->integer('total_poin');
                    $table->timestamps();
                });
            }

            /**
             * Reverse the migrations.
             */
            public function down(): void
            {
                Schema::dropIfExists('table_sales');
            }
        };

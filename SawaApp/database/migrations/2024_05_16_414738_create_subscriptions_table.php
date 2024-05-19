<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->enum('bundle_size', ['100GB', '5GB', '10GB', '30GB', '50GB', '75GB']);
            $table->integer('current_usage')->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('speed', ['1MB', '4MB', '8MB', '16MB'])->default('1MB');
            $table->enum('status', ['active', 'limited', 'suspended'])->default('active');
            $table->foreignId('service_type_id')->constrained();
            $table->timestamps();
        });
        DB::statement("
        CREATE TRIGGER calculate_end_date BEFORE INSERT ON subscriptions
        FOR EACH ROW BEGIN
            DECLARE duration INT;
            CASE NEW.bundle_size
                WHEN '100GB' THEN SET duration = 30;
                WHEN '5GB' THEN SET duration = 30;
                WHEN '10GB' THEN SET duration = 30;
                WHEN '30GB' THEN SET duration = 30;
                WHEN '50GB' THEN SET duration = 30;
                WHEN '75GB' THEN SET duration = 30;
                ELSE SET duration = 30;
            END CASE;
            SET NEW.end_date = DATE_ADD(NEW.start_date, INTERVAL duration DAY);
        END
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};

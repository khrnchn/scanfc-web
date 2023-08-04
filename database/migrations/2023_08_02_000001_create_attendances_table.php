<?php

use App\Enums\AttendanceStatusEnum;
use App\Enums\ExemptionStatusEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('classroom_id');
            $table->foreignId('enrollment_id');
            $table->enum('attendance_status', AttendanceStatusEnum::toValues());
            $table->enum('exemption_status', ExemptionStatusEnum::toValues())->nullable();
            $table->string('exemption_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};

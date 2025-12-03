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
        Schema::create('uploaded_files', function (Blueprint $table) {
            $table->id();
            // 다형성 관계를 위한 필드
            // 이 한 줄로 fileable_id (unsignedBigInteger)와 fileable_type (string) 두 필드가 생성됨
            // fileable_type: 모델 클래스 이름이 저장됨 (예: App\Models\Post)
            // fileable_id: 해당 모델의 기본 키 값이 저장됨
            $table->morphs('fileable'); 
            $table->string('file_path');
            $table->string('file_name');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploaded_files');
    }
};

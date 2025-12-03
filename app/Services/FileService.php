<?php

namespace App\Services;

use Illuminate\Http\UploadedFile as HttpFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\UploadedFile;

class FileService
{
    public function attachmentImage(HttpFile $file) {
      
        // php artisan storage:link 으로 생성된 심볼릭 링크를 통해 public/storage/ 경로에 접근 가능
        $path = $file->store('attachments', 'public'); // 'public' 디스크에 attachments 폴더에 저장

        return Storage::url($path);
    }

    public function upload(HttpFile $file, Model $model, string $folder) {

        // php artisan storage:link 으로 생성된 심볼릭 링크를 통해 public/storage/ 경로에 접근 가능
        $path = $file->store($folder, 'public'); // 'public' 디스크에 $folder 폴더에 저장

        // 다형성 관계를 통해 업로드된 파일과 모델 인스턴스 연결
        // uploadedFiles() 메서드는 모델에 정의된 다형성 관계 메서드
        // 예: $model이 Post 인스턴스라면 Post 모델의 uploadedFiles() 메서드 호출
        $model->uploadedFiles()->create([
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
        ]);
    }

    public function delete(UploadedFile $file) {
        $file->delete();
    }

    public function ForceDelete(UploadedFile $file) {
        // 실제 파일 삭제
        if (Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }
        $file->forceDelete();
    }

    public function restore(UploadedFile $file)
    {
        // 파일 모델의 deleted_at 컬럼을 null로 만듦
        $file->restore();
    }

    public function download(UploadedFile $file)
    {
        if(!Storage::disk('public')->exists($file->file_path)) {
            abort(404, '파일을 찾을 수 없습니다.');
        }
        // 파일 다운로드 응답 생성
        return Storage::disk('public')->download($file->file_path, $file->file_name);
    }
}
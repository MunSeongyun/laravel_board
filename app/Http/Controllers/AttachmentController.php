<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    // __invoke 메서드로 단일 액션 컨트롤러 구현
    public function __invoke(Request $request)
    {
        $request->validate([
            'attachment' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // php artisan storage:link 으로 생성된 심볼릭 링크를 통해 public/storage/ 경로에 접근 가능
        $path = $request->file('attachment')->store('attachments', 'public'); // 'public' 디스크에 attachments 폴더에 저장

        return response()->json([
            'image_url' => Storage::url($path),
        ]);
    }
}

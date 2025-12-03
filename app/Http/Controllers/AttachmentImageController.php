<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FileService;

class AttachmentImageController extends Controller
{
    // __invoke 메서드로 단일 액션 컨트롤러 구현
    public function __invoke(Request $request, FileService $FileService)
    {
        $request->validate([
            'attachment' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $path = $FileService->attachmentImage(
            $request->file('attachment')
        );

        return response()->json([
            'image_url' => $path,
        ]);
    }
}

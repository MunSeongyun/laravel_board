<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'attachment' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $path = $request->file('attachment')->store('attachments', 'public');

        return response()->json([
            'image_url' => Storage::url($path),
        ]);
    }
}

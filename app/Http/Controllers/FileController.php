<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class FileController extends Controller
{

    public function getUploadImage(Request $request, $row, $path): void
    {
        $file = $request->file('image');
        if ($file) {
            $filename = time() . '.png';
            $path = public_path($path . '/' . $filename);
            Image::make($file->getRealPath())->save($path);
            $row->update([
                'image' => $filename
            ]);
        }
    }

    public function store(Request $request)
    {

        $file = $request->file('file');
        $fileName = time() . $file->getClientOriginalName();
        $file->move(public_path('files'), $fileName);

        File::create([
            'fileable_type' => $request->model,
            'fileable_id' => $request->id,
            'file' => $fileName,
            'type' => $request->file('file')->getClientMimeType(),
            'title' => $request->title
        ]);

        return back();
    }

    public function delete($id)
    {
        $row = File::where('id', $id)->first();
        $row->delete();
    }

    public function downloadfile($id)
    {
        $row = File::where('id', $id)->first();
        $filepath = public_path('files/' . $row->file);
        return Response::download($filepath);
    }
}

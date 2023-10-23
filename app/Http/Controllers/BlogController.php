<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\File;
use Illuminate\Http\Request;

class BlogController extends Controller
{


    /**
     * ImageController constructor.
     */
    public function __construct()
    {
        $this->fileController = new FileController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Blog::paginate(30);
        return view('panel.blog.index', ['rows' => $rows]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.blog.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $row = Blog::create([
            'title' => $request->title,
            'body' => $request->body,
            'little_body' => $request->little_body,
            'user_id' => 1,

        ]);
        $this->fileController->getUploadImage($request, $row, 'blog');
        alert()->success('وبلاگ جدید با موفقیت افزوده شد', 'عملیات موفق');

        return redirect('blogs');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = Blog::where('id', $id)->first();
        return view('panel.blog.edit', ['row' => $row]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $row = Blog::where('id', $id)->first();
        $row->update([
            'title' => $request->title,
            'body' => $request->body,
            'little_body' => $request->little_body,
        ]);
        $this->fileController->getUploadImage($request, $row, 'blog');
        alert()->success('وبلاگ جدید با موفقیت افزوده شد', 'عملیات موفق');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Blog::where('id', $id)->first();
        $row->delete();
    }

    public function files($id)
    {
        $files = Blog::where('id', $id)->with('files')->first();
        return view('panel.blog.files', ['id' => $id, 'model' => 'App\Models\Blog', 'files' => $files]);
    }
}

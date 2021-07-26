<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Posts::orderBy('created_at', 'DESC')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newPost = new Posts;
        $newPost->title = $request->post['title'];
        $newPost->content = $request->post["content"];
        $newPost->author_id = $request->post["author_id"];
        $newPost->save();

        return $newPost;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $existing_post = Posts::find($id);

        if($existing_post && $existing_post->author_id == $request->post["author_id"]){
            $existing_post->title =  $request->post["title"];
            $existing_post->content =  $request->post["content"];
            $existing_post->save();
            return $existing_post;
        }else{
            return "Error";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $existing_post = Posts::find($id);
        if($existing_post &&  $existing_post->author_id == $request->post["author_id"] ){
            $existing_post->delete();
            return "Deleted";
        }else{
           return  "error";
        }
    }
}
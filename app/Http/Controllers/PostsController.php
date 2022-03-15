<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use  App\models\post;
use DB;
class PostsController extends Controller
{
    //  Create a new pOSTS controller instance.

    public function __construct()
    {
        $this->middleware('auth',['except' => ['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $Posts = posts::all();
        //$posts =  post::where("title","Post Two")->get();
        //  $posts =  post::orderBy("title","desc")->take(1)->get();
        //  $posts =  DB::select('SELECT * FROM `POSTS`');
        $Posts = post::orderBy("created_at","desc")->paginate(10);
        return view("posts.index")->with("posts",$Posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("posts.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image| nullable|max:1999',
        
               ]);
        // Handle FileUpload
        if($request->hasFile('cover_image')){
            // Get Filename with extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get FileName
            $fileName = pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            // get EXT
            $fileExtension =  $request->file('cover_image')->getClientOriginalExtension();
            // FileNAME tO STORE
            $fileNameToStore = $fileName ."_".time().".".$fileExtension;
            // Upload Image
            $path = $request->file('cover_image')->storeAS('public/cover_images',$fileNameToStore);
     
        }else{
            $fileNameToStore = 'noImage.jpg';
        }

        
        //create post
        $post = new post;
        $post->title =$request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();
        return redirect('/posts')->with('success','post created');

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
        $post = post::find($id);
        return view("posts.show")->with("post",$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // check for the correct user
        $post = post::find($id);
        if(auth()->user()->id !== $post->user_id){
            return redirect("/posts")->with("error","Unauthorized Page");

        }
        return view("posts.edit")->with("post",$post);
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
        $this->validate($request,[
            'title' => 'required',
            'body' => 'required'
        ]);
        // Handle FileUpload
        if($request->hasFile('cover_image')){
            // Get Filename with extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get FileName
            $fileName = pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            // get EXT
            $fileExtension =  $request->file('cover_image')->getClientOriginalExtension();
            // FileNAME tO STORE
            $fileNameToStore = $fileName ."_".time().".".$fileExtension;
            // Upload Image
            $path = $request->file('cover_image')->storeAS('public/cover_images',$fileNameToStore);
     
        }
        
        //Update post
        $post = post::find($id);
        $post->title =$request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_image')){
            $post->cover_image = $fileNameToStore;
        }
        $post->save();
        return redirect('/posts')->with('success','post Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = post::find($id);
        if(auth()->user()->id !== $post->user_id){
            return redirect("/posts")->with("error","Unauthorized Page");

        }
        if($post->cover_image != 'noImage.jpg'){
            Storage::delete('public\cover_images/'.$post->cover_image);
        }
        $post->delete();
        // return Redirect::back()->with('success','post Removed');
        return redirect('/posts')->with('success','post Removed');

    }
}
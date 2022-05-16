<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\PostDec;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::orderByDesc('id')->get();
        return view('comment.commentlist', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $posts = Post::where('is_active', 1)->get();
        return view('comment.addcomment', compact('posts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // dd($request->all());

            $data = [
                'post_id'   => $request->post_id,
                'name'      => $request->name,
                'email'     => $request->email,
                'comment'   => $request->comment,
                'is_active' => $request->is_active
            ];

            $comment = Comment::create($data);
            if(!$comment)
                throw new Exception('Unable to create comment', 403);

            return redirect(route('comment.comment_list'));

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        $posts = Post::where('is_active', 1)->get();
        return view('comment.editcomment', compact('comment','posts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        try {
            // dd($request->all());

            $data = [
                'post_id'   => $request->post_id,
                'name'      => $request->name,
                'email'     => $request->email,
                'comment'   => $request->comment,
                'is_active' => $request->is_active
            ];

            $comment = $comment->update($data);
            if(!$comment)
                throw new Exception('Unable to update comment', 403);

            return redirect(route('comment.comment_list'));

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        try {
             $delete = $comment->delete();
             if(! $delete)
                throw new Exception('Unable to remove comment!', 403);

            return redirect(route('comment.comment_list'));

        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}

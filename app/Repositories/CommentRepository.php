<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Models\Comment;
use Illuminate\Support\Facades\Hash;

class CommentRepository implements CommentRepositoryInterface
{
    public function allComment()
    {
        return Comment::with('user')
        ->where('deleted_at', 0)
        ->get();
    }

    public function allCommentByProductId($product_id)
    {
        return Comment::with('user')
        ->where('deleted_at', 0)
        ->where('product_id', $product_id)
        ->get();
    }

    public function storeComment($data)
    {
        return Comment::create($data);
    }

    public function findComment($id)
    {
        return Comment::with('user')
        ->find($id);
    }

    public function updateComment($data, $id)
    {
        $comment = Comment::where('id', $id)->first();
        $comment->admin_reply = $data['admin_reply'];
        $comment->save();
    }

    public function updateLikes($data, $id)
    {
        $comment = Comment::where('id', $id)->first();
        $comment->likes = $data;
        $comment->save();
    }

    public function destroyComment($id)
    {
        $comment = Comment::find($id);
        $comment->deleted_at = 1;
        $comment->save();
    }

}

<?php
namespace App\Repositories\Interfaces;

Interface CommentRepositoryInterface{
    public function allComment();
    public function allCommentByProductId($product_id);
    public function updateLikes($data, $id);
    public function storeComment($data);
    public function findComment($id);
    public function updateComment($data, $id);
    public function destroyComment($id);

}
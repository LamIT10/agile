<?php
class CommentModel extends Model
{
    public $table = "comments";
    public function getAllInforComment($order_id)
    {
        $sql = "SELECT * FROM orders a inner join order_details b
        on a.order_id = b.order_id inner join variants c
        on c.variant_id = b.variant_id inner join products d
        on d.product_id = c.product_id inner join colors e 
        on e.color_id = c.color_id inner join sizes f 
        on f.size_id = c.size_id where a.order_id = $order_id";
        return $this->selectAll($sql);
    }
    public function getCommentOfProduct($product_id)
    {
        $sql = "SELECT a.*,avatar,full_name,b.user_id from comments a inner join users b
        on a.user_id = b.user_id where a.product_id = $product_id";
        return $this->selectAll($sql);
    }
    public function getAll()
    {
        $sql = "SELECT b.*,MAX(a.create_at) as newest,MIN(a.create_at) as oldest,count(a.comment_id) as total FROM comments a inner join products b on a.product_id = b.product_id group by a.product_id";
        return $this->selectAll($sql);
    }
    public function getCommentDetail($id){
        $sql = "SELECT * FROM comments inner join users where product_id = $id and comments.user_id = users.user_id";
        return $this->selectAll($sql);
    }
}

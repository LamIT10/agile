<?php
class CommentController extends Controller
{
    public $comment;
    public $category;
    public $order;
    public $product;
    public function __construct()
    {
        $this->loadModel("CommentModel");
        $this->comment = new CommentModel();
        $this->loadModel("CategoryModel");
        $this->category = new CategoryModel();
        $this->loadModel("OrderModel");
        $this->order = new OrderModel();
        // $this->loadModel("ProductModel")
    }
    public function index()
    {
        $title = "Đánh giá";
        $orderInfor = $this->comment->getAllInforComment($_GET['order_id']);
        $category = $this->category->select("*");
        $content = "client/rate";
        $layoutPath = "client_layout";
        $this->renderView($layoutPath, $content, ['title' => $title, 'category' => $category, 'orderInfor' => $orderInfor]);
    }
    public function store()
    {
        try {
            $countRecord = count($_POST['rating']);
            $count = 0;
            $order_id = $_GET['order_id'];
            foreach ($_POST['rating'] as $key => $value) {
                $lastInsertID = $this->comment->insert($value);
                if ($lastInsertID > 0) {
                    $count++;
                }
            }
            if ($count == $countRecord) {
                $this->order->update(['order_status' => 4], "order_id = :order_id", ['order_id' => $order_id]);
                $_SESSION['success'] = true;
                $_SESSION['message'] = "Đánh giá sản phẩm thành công";
                header("Location:?controller=order");
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function delete()
    {
        $this->comment->delete("comment_id = :comment_id", ["comment_id" => $_GET['id']]);
        $_SESSION['success'] = true;
        $_SESSION['message'] = "Xóa bình luận thành công";
        header("Location:" . $_SERVER['HTTP_REFERER']);
    }
}

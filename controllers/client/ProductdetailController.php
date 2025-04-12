<?php
class ProductdetailController extends Controller
{
    private $product;
    public $category;
    public $comment;
    public function __construct()
    {
        $this->loadModel("ProductModel");
        $this->product = new ProductModel();
        $this->loadModel("CategoryModel");
        $this->category = new CategoryModel;
        $this->loadModel("CommentModel");
        $this->comment = new CommentModel();
    }
    public function index()
    {
        $id = $_GET['id'];
        $colorId = $_GET['colorId'];
        $sizeId = $_GET['sizeId'];
        $viewOfProduct = $this->product->selectOne("product_view", "product_id = :id", ["id" => $id]);
        $view =  $viewOfProduct['product_view'];
        $this->product->update(['product_view' => $view + 1], "product_id = :id", ["id" => $id]);
        $productDetail = $this->product->getProductDetail($id, $colorId, $sizeId);
        $allComment = $this->comment->getCommentOfProduct($id);
        $rating = $this->product->getRating($id);
        $category = $this->category->getAllCategory();
        $title = "Trang chi tiết sản phẩm";
        $content = "client/ProductDetailClient";
        $layoutPath = "client_layout";
        $this->renderView($layoutPath, $content, ["productDetail" => $productDetail, "category" => $category, "title" => $title, "allComment" => $allComment, "rating" => $rating]);
    }
}

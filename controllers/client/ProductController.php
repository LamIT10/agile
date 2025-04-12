<?php
class ProductController extends Controller
{
    public $product;
    public $category;
    public function __construct()
    {
        $this->loadModel("ProductModel");
        $this->product = new ProductModel();
        $this->loadModel("CategoryModel");
        $this->category = new CategoryModel();
    }
    public function searchByName()
    {
        if (isset($_POST['key'])) {
            $_SESSION['key'] = $_POST['key'];
        }
        $result = "Hiển thị kết quả tìm kiếm của từ khoá: <b class='text-primary'>{$_SESSION['key']}</b>";
        $list = $this->product->searchByName($_SESSION['key']);
        $title = "Sản phẩm";
        $category = $this->category->select("*", "status = 1");
        $content = "client/product";
        $layoutPath = "client_layout";
        $this->renderView($layoutPath, $content, ['title' => $title, 'list' => $list, 'category' => $category, 'result' => $result]);
    }
    public function searchByCategory()
    {
        $id = $_GET['id'];
        $cate_name = $this->category->selectOne("category_name", "category_id = :category_id AND status = 1", ['category_id' => $id])['category_name'];
        $result = "Trang chủ / <b class='text-primary'>$cate_name</b>";
        $list = $this->product->searchByCategory($id);
        $title = "Sản phẩm";
        $category = $this->category->select("*", "status = 1");
        $content = "client/product";
        $layoutPath = "client_layout";
        $this->renderView($layoutPath, $content, ['title' => $title, 'list' => $list, 'category' => $category, 'result' => $result]);
    }
    public function searchByParent()
    {
        $id = $_GET['id'];
        $result = '';
        $banner = $this->category->selectOne("banner", "category_id = :category_id AND status = 1", ['category_id' => $id]);
        $childCategory = $this->category->select("*", "parent_id = :category_id AND status = 1", ['category_id' => $id]);
        $list = $this->product->searchByParent($id);
        $title = "Sản phẩm";
        $category = $this->category->select("*", "status = 1");
        $content = "client/product";
        $layoutPath = "client_layout";
        $this->renderView($layoutPath, $content, ['title' => $title, 'list' => $list, 'category' => $category, 'banner' => $banner, 'result' => $result, 'child' => $childCategory]);
    }
}

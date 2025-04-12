<?php
class HomeController extends Controller
{
    public $category;
    public $order;
    public function __construct()
    {
        // $this->loadModel("CategoryModel");
        // $this->category = new CategoryModel();
    }
    public function index()
    {
        // $category = $this->category->getAllCategory();
        // $title = "Bảng điều khiển";
        // $content = "admin/dashboard/Home";
        // $layoutPath = "admin_layout";
        // $this->renderView($layoutPath, $content, ["title" => $title, "content" => $content, "category" => $category]);
    }
    // public function revenue()
    // {
    //     if ($_SESSION['user']['role'] != 1) {
    //         header("Location: ?role=admin");
    //     }
    //     $total = $this->order->getTotalByDate();
    //     $total7Day = $this->order->getRevenue7Day();
    //     $title = "Bảng doanh thu";
    //     $content = "admin/dashboard/revenue";
    //     $layoutPath = "admin_layout";
    //     $this->renderView($layoutPath, $content, ["title" => $title, "content" => $content, "total" => $total, "total7Day" => $total7Day]);
    // }
    // public function product()
    // {
    //     $title = "Thống kê sản phẩm";
    //     $content = "admin/dashboard/product";
    //     $list = $this->order->getProductBestSell();
    //     $layoutPath = "admin_layout";
    //     $this->renderView($layoutPath, $content, ["title" => $title, "content" => $content, "list" => $list]);
    // }
}

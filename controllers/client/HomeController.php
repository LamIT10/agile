<?php
class HomeController extends Controller
{
     public $category;
     public $banner;
     public $product;
     public function __construct()
     {
          // $this->loadModel("CategoryModel");
          // $this->category = new CategoryModel();
          // $this->loadModel("BannerModel");
          // $this->banner = new BannerModel();
          // $this->loadModel("ProductModel");
          // $this->product = new ProductModel();
     }
     public function index()
     {
          echo "index";
          // $category = $this->category->select("*");
          // $listBanners = $this->banner->getAllBanner();
          // $listView = $this->product->getProductFilterByView();
          // $listNew = $this->product->getProductFilterNew();
          // $title = "Trang chủ";
          // $content = "client/HomeClient";
          // $layoutPath = "client_layout";
          // $this->renderView($layoutPath, $content, ["title" => $title, "content" => $content, "category" => $category, "listBanners" => $listBanners, "listView" => $listView, "listNew" => $listNew]);
     }
}

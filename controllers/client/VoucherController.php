<?php
class VoucherController extends Controller
{
    public $voucher;
    public $category;
    public function __construct()
    {
        $this->loadModel("VoucherModel");
        $this->voucher = new VoucherModel();
        $this->loadModel("CategoryModel");
        $this->category = new CategoryModel();
    }
    public function index()
    {
        $title = "Kho voucher";
        $voucherUsed = $this->voucher->checkVoucherUsedByUser($_SESSION['user']['user_id']);
        $listVoucher = $this->voucher->select("*");
        $content = "client/voucher";
        $category = $this->category->select("*");
        $layoutPath = "client_layout";
        $this->renderView($layoutPath, $content, ['title' => $title, 'listVoucher' => $listVoucher, 'category' => $category,'voucherUsed'=>$voucherUsed]);
    }
}

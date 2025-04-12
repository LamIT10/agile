<?php
class CheckoutController extends Controller
{
    public $cart;
    public $variant;
    public $voucher;
    public $infor;
    public function __construct()
    {
        $this->loadModel("CartModel");
        $this->cart = new CartModel();
        $this->loadModel("VariantModel");
        $this->variant = new VariantModel();
        $this->loadModel("VoucherModel");
        $this->voucher = new VoucherModel();
        $this->loadModel("InforreceptModel");
        $this->infor = new InforReceptModel;
    }
    public function index()
    {
        $title = "Checkout";
        $layoutPath = "checkout_layout";
        $idCartDetail = $_SESSION['cart'];
        $order = [];
        foreach ($idCartDetail as $key => $value) {
            $order[] = $this->cart->getCartDetailById($value);
        }
        $total = $this->getTotalPrice($idCartDetail);
        $totalFinal = 0;
        $discount = 0;
        $inforUsedTo = $this->infor->select("*", "user_id = {$_SESSION['user']['user_id']}");
        if (isset($_SESSION['voucher'])) {
            $discount = $_SESSION['voucher']['discount'];
            $totalFinal = $total - $discount;
        }
        $this->renderView($layoutPath, "", ["title" => $title, "order" => $order, "totalPrice" => $total, "totalFinal" => $totalFinal, "discount" => $discount, "inforUsedTo" => $inforUsedTo]);
    }
    public function getTotalPrice($data = [])
    {
        $total = 0;
        $list = $this->cart->getCartDetailByArrayId($data);
        foreach ($list as $key => $value) {
            $total += $value['quantity_cart'] * $value['sale_price'];
        }
        return $total;
    }

    public function addVoucher()
    {
        try {
            if (isset($_POST['btn-add'])) {
                $listVoucher = $this->voucher->select("*");
                $check = true;
                if (isset($_SESSION['cart'])) {
                    $total = $this->getTotalPrice($_SESSION['cart']);
                }
                foreach ($listVoucher as $key => $value) {
                    if ($value['voucher_code'] == $_POST['voucher_code']) {
                        $check = false;
                        $voucherWasUsed = $this->voucher->checkVoucherUsed($value['voucher_id'], $_SESSION['user']['user_id']);
                        if (!empty($voucherWasUsed)) {
                            throw new Exception("Bạn đã sử dụng voucher này");
                        }
                        if ($value['min_price'] > $total) {
                            throw new Exception("Giá trị đơn hàng chưa đủ để áp mã này");
                        } else {
                            $_SESSION['success'] = true;
                            $_SESSION['message'] = "Áp mã giảm giá thành công";
                            $_SESSION['voucher'] = $value;
                        }
                    }
                }
                if ($check == true) {
                    unset($_SESSION['voucher']);
                    throw new Exception("Không tồn tại mã giảm giá này");
                }
            } else {
                unset($_SESSION['voucher']);
                $_SESSION['success'] = true;
                $_SESSION['message'] = "Đã huỷ mã giảm giá";
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
        }
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
    public function useInforOld()
    {
        $id = $_GET['id'];
        $infor = $this->infor->selectOne("*", "infor_id = :infor_id", ["infor_id" => $id]);
        foreach ($infor as $key => $value) {
            $_SESSION['inforUsedTo'][$key] = $value;
        }
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
    public function unUseInforOld()
    {
        if (isset($_SESSION['inforUsedTo'])) {
            unset($_SESSION['inforUsedTo']);
        }
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}

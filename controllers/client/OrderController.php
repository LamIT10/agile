<?php
class OrderController extends Controller
{
    public $order;
    public $cart;
    public $inforRecept;
    public $voucher;
    public $category;
    public $variant;
    public function __construct()
    {
        $this->loadModel("OrderModel");
        $this->order = new OrderModel();
        $this->loadModel("CartModel");
        $this->cart = new CartModel();
        $this->loadModel("InforReceptModel");
        $this->inforRecept = new InforReceptModel();
        $this->loadModel("VoucherModel");
        $this->voucher = new VoucherModel();
        $this->loadModel("CategoryModel");
        $this->category = new CategoryModel();
        $this->loadModel("VariantModel");
        $this->variant = new VariantModel();
    }
    public function index()
    {
        $title = "Đơn hàng";
        $category = $this->category->select("*", "status = :status", ["status" => 1]);
        $listOrder = $this->order->select("*", "user_id = :user_id", ['user_id' => $_SESSION['user']['user_id']]);
        $listOrderDetail = $this->order->showOrderByUser($_SESSION['user']['user_id']);
        $content = "client/order";
        $layoutPath = "client_layout";
        $this->renderView($layoutPath, $content, ["title" => $title, "listOrder" => $listOrder, "category" => $category, "listOrderDetail" => $listOrderDetail]);
    }
    public function createOrder($payment_method, $payment_status)
    {
        try {
            if (isset($_SESSION['voucher']))
                $voucher_id = $_SESSION['voucher']['voucher_id'];
            else $voucher_id = null;

            $list = $this->cart->getCartDetailByArrayId($_SESSION['cart']);
            foreach ($list as $key => $value) {
                $inStock = $this->variant->selectOne("quantity", "variant_id = :variant_id", ["variant_id" => $value['variant_id']]);
                if ($value['quantity_cart'] > $inStock['quantity']) {
                    throw new Exception("Một số sản phẩm trong giỏ hàng hiện có số lượng không hợp lệ!", 1);
                }
            }
            if (isset($_SESSION['inforUsedTo'])) {
                $idInforLast = $this->inforRecept->selectOne("infor_id", "infor_id = :infor_id", ["infor_id" => $_SESSION['inforUsedTo']['infor_id']])['infor_id'];
            } else {
                $dataInforRecept = [
                    "name" => $_SESSION['dataOrder']['name'],
                    "address" => $_SESSION['dataOrder']['city_name'] . " - " . $_SESSION['dataOrder']['district_name'] . " - " . $_SESSION['dataOrder']['ward_name'],
                    "phone" => $_SESSION['dataOrder']['phone'],
                    "user_id" => $_SESSION['user']['user_id']
                ];
                $idInforLast = $this->inforRecept->insert($dataInforRecept);
            }
            $dataOrder = [
                "user_id" => $_SESSION['user']['user_id'],
                "infor_id" => $idInforLast,
                "voucher_id" => $voucher_id,
                "final_price" => $_SESSION['dataOrder']['final_price'],
                "payment_status" => $payment_status,
                "payment_method" => $_SESSION['dataOrder']['payment_method']
            ];
            $idOrderLast = $this->order->insert($dataOrder);
            $dataOrderDetail = [];
            foreach ($list as $key => $value) {
                $dataOrderDetail = [
                    "order_id" => $idOrderLast,
                    "variant_id" => $value['variant_id'],
                    "quantity" => $value['quantity_cart'],
                    "price" => $value['sale_price']
                ];
                $this->order->insert2($dataOrderDetail, "order_details");
                $this->cart->removeCartDetail($_SESSION['cart']);
                if (isset($_SESSION['inforUsedTo'])) {
                    unset($_SESSION['inforUsedTo']);
                }
                $_SESSION['cart'] = [];
                unset($_SESSION['dataOrder']);
                unset($_SESSION['voucher']);
            }
            if (isset($voucher_id)) {
                $this->voucher->decrease($voucher_id);
                $this->voucher->addToTableUsedTo($voucher_id, $_SESSION['user']['user_id']);
            }

            $_SESSION['success'] = true;
            $_SESSION['message'] = "Đặt hàng thành công";
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
            if ($th->getCode() == 1) {
                header("Location: ?controller=cart");
                exit();
            }
        }
        header("Location: index.php");
    }
    public function store()
    {
        try {
            $_SESSION['dataOrder'] = $_POST;
            $data = $_SESSION['dataOrder'];
            $_SESSION['error'] = [];
            if (!isset($_SESSION['inforUsedTo'])) {
                if ($data['name'] == '') {
                    $_SESSION['error']['name'] = 'Vui lòng nhập tên người nhận hàng';
                }
                if ($data['city_name'] == '' || $data['district_name'] == '' || $data['ward_name'] == '') {
                    $_SESSION['error']['address'] = 'Vui lòng nhập đầy đủ địa chỉ giao hàng';
                }
                if ($data['phone'] == '') {
                    $_SESSION['error']['phone'] = 'Vui lòng nhập số diện thoại người nhận hàng';
                }
            }
            if (!empty($_SESSION['error'])) {
                throw new Exception("Dữ liệu lỗi");
            } else {
                if ($_POST['payment_method'] == 0) {
                    $this->createOrder(0, 0);
                } else if ($_POST['payment_method'] == 1) {
                    $url = $this->vnpayment($_POST['final_price']);
                    header("Location: " . $url);
                }
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
            header("Location: " . $_SERVER['HTTP_REFERER']);
        }
    }
    public function vnpayment($final_price)
    {
        require_once "config/config.php";
        $vnp_TxnRef = "ROYAL" . time();
        $vnp_Amount = $_POST['final_price'];
        $vnp_Locale = 'vn';
        $vnp_BankCode = "NCB";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan giao dich: " . $vnp_TxnRef,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $expire
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return $vnp_Url;
    }
    public function vnpayment_return()
    {
        $vnp_HashSecret = "TJMZJ5L4QUCVVDHCCM9C84H91HQ2OOSL";
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        $hashData = rtrim($hashData, '&');
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash == $vnp_SecureHash) {
            if ($_GET['vnp_ResponseCode'] == '00') {
                $this->createOrder(1, 1);
                header("Location: index.php");
            } else {
                $_SESSION['success'] = false;
                $_SESSION['message'] = "Giao dịch không thành công: " . $_GET['vnp_Message'];
                header("Location: index.php");
            }
        } else {
            $_SESSION['success'] = false;
            $_SESSION['message'] = "Có lỗi xảy ra trong quá trình xác minh giao dịch.";
            header("Location: index.php");
        }
    }
    public function cancelOrder()
    {
        $order_id = $_GET['order_id'];
        $row = $this->order->update(['order_status' => 5], "order_id = :order_id", ['order_id' => $order_id]);
        if ($row > 0) {
            $_SESSION['success'] = true;
            $_SESSION['message'] = "Huỷ đơn hàng thành công";
            header("Location:" . $_SERVER['HTTP_REFERER']);
        }
    }
    public function shippingSuccess()
    {
        $order_id = $_GET['order_id'];
        $row = $this->order->update(['order_status' => 3, 'payment_status' => 1], "order_id = :order_id", ['order_id' => $order_id]);
        if ($row > 0) {
            $_SESSION['success'] = true;
            $_SESSION['message'] = "Bạn đã xác nhận giao hàng thành công";
            header("Location:" . $_SERVER['HTTP_REFERER']);
        }
    }
}

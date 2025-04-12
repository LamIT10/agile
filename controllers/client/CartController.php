<?php
class CartController extends Controller
{
    public $cart;
    public $category;
    public $variant;
    public function __construct()
    {
        $this->loadModel("CartModel");
        $this->cart = new CartModel();
        $this->loadModel("CategoryModel");
        $this->category = new CategoryModel();
        $this->loadModel("VariantModel");
        $this->variant = new VariantModel();
    }
    public function index()
    {
        $category = $this->category->getAllCategory();
        $cart = $this->cart->getAllInCart();
        $title = "Giỏ hàng";
        $content = "client/cart";
        $layoutPath = "client_layout";
        $this->renderView($layoutPath, $content, ["title" => $title, "content" => $content, "category" => $category, "cart" => $cart]);
    }
    public function store()
    {
        try {
            $data = $_POST;
            $product = $this->variant->getVariant($data['variant_id']); // lấy ra variant muốn thêm vào
            if ($data['quantity_cart'] > $product['quantity']) {
                throw new Exception("Số lượng sản phẩm không hợp lệ!");
            }
            $haveCart = $this->cart->select("*", "user_id = :user_id", ['user_id' => $_SESSION['user']['user_id']]); // check xem đã có id người dùng ở giỏ hàng chưa
            if (empty($haveCart)) {
                $this->cart->insert(['user_id' => $_SESSION['user']['user_id']]); // nếu chưa thì add vào
            }
            $cart = $this->cart->selectOne("*", "user_id = :user_id", ['user_id' => $_SESSION['user']['user_id']]); // lấy ra 1 giỏ hàng của người dùng
            $isInCart = $this->variant->isInCartDetail($data['variant_id'], $cart['cart_id']); // check xem biến thể này có ở giỏ hàng chưa
            // var_dump($isInCart);die;
            // var_dump($isInCart[0]['quantity_cart']);die;
            if (!empty($isInCart)) {
                $quantityCartNew = $data['quantity_cart'] + $isInCart[0]['quantity_cart'];
                if ($quantityCartNew > $product['quantity']) {
                    throw new Exception("Số lượng sản phẩm không hợp lệ, trong giỏ hàng của bạn đã có có {$isInCart[0]['quantity_cart']} sản phẩm này");
                } else {
                    $rowCount = $this->cart->updateQuantity(['quantity_cart' => $quantityCartNew, 'detail_id' => $isInCart[0]['detail_id']]);
                    if ($rowCount > 0) {
                        $_SESSION['success'] = true;
                        $_SESSION['message'] = "Thêm sản phẩm vào giỏ hàng thành công";
                    }
                }
            } else {
                $this->cart->storeCartDetail(['cart_id' => $cart['cart_id'], 'variant_id' => $data['variant_id'], 'quantity_cart' => $data['quantity_cart']]);
                $_SESSION['success'] = true;
                $_SESSION['message'] = "Thêm sản phẩm vào giỏ hàng thành công";
            }
            header("location: {$_SERVER['HTTP_REFERER']}");
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
            header("location: {$_SERVER['HTTP_REFERER']}");
        }
    }
    public function delete()
    {
        try {
            $id = $_GET['id'];
            $row = $this->cart->deleteCart($id);
            if ($row > 0) {
                unset($_SESSION['cart'][$id]);
                $_SESSION['success'] = true;
                $_SESSION['message'] = "Xoá sản phẩm trong giỏ hàng thành công";
            } else {
                throw new Exception("Xoá sản phẩm không thành công");
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
        }
        header("location: {$_SERVER['HTTP_REFERER']}");
    }
    public function changeQuantity()
    {
        try {
            $data = $_POST;
            $product = $this->variant->getVariant($data['variant_id']); // lấy ra variant muốn thêm vào
            if ($data['quantity_cart'] > $product['quantity']) {
                throw new Exception("Số lượng sản phẩm không hợp lệ!");
            }
            if ($data['quantity_cart'] > 0) {
                $row = $this->cart->updateQuantity(['quantity_cart' => $data['quantity_cart'], 'detail_id' => $_GET['id']]);
                if ($row > 0) {
                    $_SESSION['success'] = true;
                    $_SESSION['message'] = "Cập nhật thành công";
                }else{
                    $_SESSION['success'] = false;
                    $_SESSION['message'] = "Cập nhật KHÔNG thành công";
                }
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
        }
        header("location: {$_SERVER['HTTP_REFERER']}");
    }
}

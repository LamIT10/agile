<?php
class OrderController extends Controller
{
    public $order;
    public $variant;
    public function __construct()
    {
        $this->loadModel("OrderModel");
        $this->order = new OrderModel();
        $this->loadModel("VariantModel");
        $this->variant = new VariantModel();
    }
    public function index()
    {
        $title = "Quản lý đơn hàng";
        $listOrder = $this->order->getAllOrder();
        $content = "admin/order/index";
        $layoutPath = "admin_layout";
        $this->renderView($layoutPath, $content, ["title" => $title, "listOrder" => $listOrder]);
    }
    public function buttonChangeStatus()
    {
        $order_id = $_GET['id'];
        $status = $_GET['status'];
        // nếu $status = 2, là admin xác nhận giao hàng thành công
        if ($status == 2) {
            $list = $this->order->getOrderDetail($order_id); // lấy các chi tiết đơn hàng nhỏ của đơn hàng
            // viết vòng for để handle xử lý cập nhật giá trị quantity của các variant có trong order details
            foreach ($list as $key => $value) {
                $this->variant->handleQuantityAfterSuccess($value['quantity'], $value['variant_id']);
            }
            $row = $this->order->handleSuccessShipping($order_id);
        } else {
            $rowCount = $this->order->buttonChangeStatus($order_id, $status);
        }
        header("Location: ?role=admin&controller=order");
    }
    public function detail(){
        $id = $_GET['id'];
        $list = $this->order->getOrderDetailByOrderId($id);
        $content = "admin/order/show";
        $layoutPath = "admin_layout";
        $title = "Chi tiết đơn hàng";
        $this->renderView($layoutPath, $content, ["title" => $title, "list" => $list]);
    }
    
}

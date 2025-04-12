<?php
class OrderModel extends Model
{
    public $table = "orders";
    public function getAllOrder()
    {
        $sql = "SELECT a.*,b.full_name from orders a inner join users b on a.user_id = b.user_id order by a.create_at desc";
        return $this->selectAll($sql);
    }
    public function buttonChangeStatus($id, $status)
    {
        if ($status == 3) {
        }
        $sql = "UPDATE orders SET order_status = $status + 1 WHERE order_id = $id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    }
    public function showOrder($user_id, $order_id)
    {
        $sql = "SELECT price,final_price,product_name,b.price, image_main,color_name,size_name,b.quantity,payment_method,payment_status,order_status from orders a inner join order_details b
      on a.order_id = b.order_id inner join variants c
      on c.variant_id = b.variant_id inner join colors d
      on d.color_id = c.color_id inner join sizes e
      on e.size_id = c.size_id inner join products pr on pr.product_id = c.product_id where a.user_id = $user_id and a.order_id = $order_id";
        $list = $this->selectAll($sql);
        return $list;
    }
    public function showOrderByUser($user_id)
    {
        $sql = "SELECT a.*, price,final_price,product_name, image_main,color_name,size_name,b.quantity from orders a inner join order_details b
      on a.order_id = b.order_id inner join variants c
      on c.variant_id = b.variant_id inner join colors d
      on d.color_id = c.color_id inner join sizes e
      on e.size_id = c.size_id inner join products pr on pr.product_id = c.product_id where a.user_id = $user_id";
        $list = $this->selectAll($sql);
        return $list;
    }
    public function handleSuccessShipping($order_id)
    {
        $sql = "UPDATE orders set order_status = 3, payment_status = 1 where order_id = $order_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    }
    public function getOrderDetail($order_id)
    {
        $sql = "SELECT * FROM order_details where order_id = $order_id";
        return $this->selectAll($sql);
    }
    public function getOrderDetailByOrderId($order_id)
    {
        $sql = "SELECT price,final_price,product_name,b.price, image_main,color_name,size_name,b.quantity,payment_method,payment_status,order_status from orders a inner join order_details b
      on a.order_id = b.order_id inner join variants c
      on c.variant_id = b.variant_id inner join colors d
      on d.color_id = c.color_id inner join sizes e
      on e.size_id = c.size_id inner join products pr on pr.product_id = c.product_id where a.order_id = $order_id";
        $list = $this->selectAll($sql);
        return $list;
    }
    public function getTotalByDate()
    {
        $sqlExtra = "";
        if (isset($_POST['start']) && isset($_POST['end'])) {
            $start = $_POST['start'];
            $end = $_POST['end'];
            $sqlExtra = " and update_at between '$start' and '$end'";
        }
        $sql = "SELECT sum(final_price) as total from orders where (order_status = 3 or order_status = 4) $sqlExtra";
        return $this->selectAll($sql);
    }
    public function getRevenue7Day()
    {
        $sql = "SELECT sum(final_price) as total, DATE(update_at) as date from orders 
        where (order_status = 3 or order_status = 4) and update_at > CURDATE() - INTERVAL 7 DAY 
        group by DATE(update_at) order by DATE(update_at) desc";
        return $this->selectAll($sql);
    }
    public function getProductBestSell()
    {
        $sqlExtra = "";
        if (isset($_POST['start']) && isset($_POST['end'])) {
            $_SESSION['start'] = $_POST['start'];
            $_SESSION['end'] = $_POST['end'];
            $sqlExtra = "AND o.update_at between '" . $_SESSION['start'] . "' and '" . $_SESSION['end'] . "'";
        }
        $sql = "SELECT sum(a.quantity) as totalQuantity,product_name,c.product_id from order_details a
        inner join variants b on a.variant_id = b.variant_id
        inner join products c on b.product_id = c.product_id inner join orders o on o.order_id = a.order_id
        where (o.order_status = 3 or o.order_status = 4)
        $sqlExtra   
        group by c.product_id order by totalQuantity desc limit 5";
        return $this->selectAll($sql);
    }
    public function checkProductInOrder($product_id)
    {
        $sql = "SELECT * FROM order_details a inner join variants b on a.variant_id = b.variant_id 
        inner join orders o on o.order_id = a.order_id
        where b.product_id = $product_id and (o.order_status = 0 or o.order_status = 1 or o.order_status = 2)";
        return $this->selectAll($sql);
    }
    public function checkVariantInOrder($variant_id)
    {
        $sql = "SELECT * FROM order_details a
        inner join orders o on o.order_id = a.order_id
        where variant_id = $variant_id and (o.order_status = 0 or o.order_status = 1 or o.order_status = 2)";
        return $this->selectAll($sql);
    }
    public function checkUseHaveOrder($user_id)
    {
        $sql = "SELECT * FROM orders where user_id = $user_id and (order_status = 0 or order_status = 1 or order_status = 2)";
        return $this->selectAll($sql);
    }
}

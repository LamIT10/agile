<?php
class CartModel extends Model
{
    public $table = "carts";
    public function getAllInCart()
    {
        $sql = "SELECT * from carts ca inner join cart_details cd on ca.cart_id = cd.cart_id 
        inner join variants v on v.variant_id = cd.variant_id 
        inner join products p on p.product_id = v.product_id
        inner join colors c 
        on v.color_id = c.color_id inner join sizes s on v.size_id = s.size_id
        where ca.user_id = {$_SESSION['user']['user_id']}";
        $listProduct = $this->selectAll($sql);
        return $listProduct;
    }
    public function storeCartDetail($data = [])
    {
        $sql = "INSERT INTO cart_details (cart_id, variant_id, quantity_cart) VALUES (:cart_id, :variant_id, :quantity_cart)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
        return $stmt->rowCount();
    }
    public function updateQuantity($data = [])
    {
        $sql = "UPDATE cart_details set quantity_cart = :quantity_cart where detail_id = :detail_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
        return $stmt->rowCount();
    }
    public function getAllInCartDetail($id)
    {
        $sql = "SELECT * from cart_details where cart_id = $id";
    }
    public function deleteCart($id)
    {
        $sql = "DELETE FROM cart_details where detail_id = $id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    }
    public function getCartDetailById($id)
    {
        $sql = "SELECT * from carts ca inner join cart_details cd on ca.cart_id = cd.cart_id 
        inner join variants v on v.variant_id = cd.variant_id 
        inner join products p on p.product_id = v.product_id 
        inner join colors c 
        on v.color_id = c.color_id inner join sizes s on v.size_id = s.size_id
        where cd.detail_id = $id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetch(PDO::FETCH_ASSOC);
        return $list;
    }
    public function getCartDetailByArrayId($data = [])
    {
        $data = implode(",", $data);
        $sql = "SELECT * from carts ca inner join cart_details cd on ca.cart_id = cd.cart_id 
        inner join variants v on v.variant_id = cd.variant_id 
        inner join products p on p.product_id = v.product_id inner join colors c 
        on v.color_id = c.color_id inner join sizes s on v.size_id = s.size_id
        where cd.detail_id IN ($data)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    }
    public function removeCartDetail($data = [])
    {
        $data = implode(",", $data);
        $sql = "DELETE FROM cart_details where detail_id IN ($data)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    }
}

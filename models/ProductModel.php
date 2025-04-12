<?php

class ProductModel extends Model
{
    public $table = "products";
    public function getAllProduct()
    {
        $sql = "SELECT * from categories ca inner join products a on ca.category_id = a.category_id where a.status = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    }
    public function getProductFilterByView()
    {
        $sql =
            "SELECT a.product_name, a.product_id,a.image, b.base_price,b.sale_price, b.color_id, b.size_id from categories ca inner join products a on ca.category_id = a.category_id 
            inner join variants b on a.product_id = b.product_id
            where a.status = 1 and a.status=1 and b.variant_main =1 order by a.product_view desc limit 8";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    }
    public function getProductFilterNew()
    {
        $sql =
            "SELECT a.product_name, a.product_id,a.image, b.base_price,b.sale_price, b.color_id, b.size_id from categories ca inner join products a on ca.category_id = a.category_id 
            inner join variants b on a.product_id = b.product_id
            where a.status = 1 and a.status=1 and b.variant_main =1 order by b.create_at desc limit 8";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    }
    public function getProductDetail($id, $colorId, $sizeId)
    {
        $sql = "SELECT * from products a inner join variants b 
        on a.product_id = b.product_id inner join colors c 
        on b.color_id = c.color_id inner join sizes d 
        on d.size_id = b.size_id where a.status = 1 and a.product_id=$id and c.color_id=$colorId and d.size_id=$sizeId";

        $sql2 = "SELECT image_link from variants a inner join image_variant b 
        on a.variant_id = b.variant_id inner join images c 
        on c.image_id = b.image_id where product_id = $id and color_id = $colorId limit 3";

        $sql3 = "SELECT * from colors x where x.color_id in 
        (SELECT color_id from variants where product_id = $id)";

        $sql4 = "SELECT size_name, c.size_id from products a inner join variants b 
        on a.product_id = b.product_id inner join sizes c 
        on b.size_id = c.size_id where a.product_id=$id and b.color_id=$colorId";

        $list = $this->selectAll($sql);

        $addToCart = true;

        if (empty($list)) {
            $addToCart = false;
            $sql = "SELECT * from products a inner join variants b 
        on a.product_id = b.product_id inner join colors c 
        on b.color_id = c.color_id inner join sizes d 
        on d.size_id = b.size_id where a.status = 1 and a.product_id=$id and c.color_id=$colorId limit 1";
            $list = $this->selectAll($sql);
        }
        $list2 = $this->selectAll($sql2);
        $list3 = $this->selectAll($sql3);
        $list4 = $this->selectAll($sql4);
        $productDetail = [
            "addToCart" => $addToCart,
            "product" => $list,
            "image" => $list2,
            "color" => $list3,
            "size" => $list4
        ];
        return $productDetail;
    }
    public function getRating($id)
    {
        $sql = "SELECT AVG(rating) as rating, COUNT(rating) as count from comments where product_id = $id group by product_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetch(PDO::FETCH_ASSOC);
        return $list;
    }
    public function searchByName($key)
    {
        $sql = "SELECT a.product_name, a.product_id,a.image, b.base_price,b.sale_price, b.color_id, b.size_id from categories ca inner join products a on ca.category_id = a.category_id 
            inner join variants b on a.product_id = b.product_id
            where a.status = 1 and a.status=1 and b.variant_main =1 and a.product_name LIKE '%$key%'";
        $list = $this->selectAll($sql);
        return $list;
    }
    public function searchByCategory($id)
    {
        $sql = "SELECT a.product_name, a.product_id,a.image, b.base_price,b.sale_price, b.color_id, b.size_id from categories ca inner join products a on ca.category_id = a.category_id 
            inner join variants b on a.product_id = b.product_id
            where a.status = 1 and a.status=1 and b.variant_main =1 and a.category_id = $id";
        $list = $this->selectAll($sql);
        return $list;
    }
    public function searchByParent($id)
    {
        $sql = "SELECT a.product_name, a.product_id,a.image, b.base_price,b.sale_price, b.color_id, b.size_id,ca.banner from categories ca inner join products a on ca.category_id = a.category_id 
            inner join variants b on a.product_id = b.product_id
            where a.status = 1 and a.status=1 and b.variant_main =1 and ca.parent_id = $id";
        $list = $this->selectAll($sql);
        return $list;
    }
}

<?php
class CategoryModel extends Model
{
    public $table = "categories";
    public function getAllCategory()
    {
        try {
            $list = $this->select("*");
            return $list;
        } catch (\Throwable $th) {
            echo $th;
        }
    }
    public function getAllDividePage()
    {
        try {
            $list = $this->dividePage($_GET["page"] ?? 1, 5, "*", "1=1 ORDER BY create_at DESC");
            return $list;
        } catch (\Throwable $th) {
            echo $th;
        }
    }
    public function getOneCategory($id)
    {
        try {
            $list = $this->selectOne("*", "category_id = :id", ["id" => $id]);
            return $list;
        } catch (\Throwable $th) {
            echo "lỗi ở đây";;
        }
    }
    public function addCategory($data)
    {
        try {
            $this->insert($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function updateCategory($data = [], $id = null)
    {
        var_dump($data);
        if (!empty($data["parent_id"])) {
            $sql = "WITH RECURSIVE category_hierarchy AS (
    SELECT category_id, parent_id
    FROM categories
    WHERE category_id = $id
    UNION ALL
    SELECT c.category_id, c.parent_id
    FROM categories c
    INNER JOIN category_hierarchy ch ON c.parent_id = ch.category_id)

    SELECT COUNT(*)
FROM category_hierarchy
WHERE category_id = {$data["parent_id"]};
";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $list = $stmt->fetch(PDO::FETCH_ASSOC);
            // var_dump($list);
            if ($list["COUNT(*)"] > 0) {
                echo "có con category";
            }
        }
        if (empty($data["parent_id"])) $data["parent_id"] = null;
        return $this->update($data, "category_id = :id", ["id" => $_GET["id"]]);
    }
    public function deleteCategory($id)
    {
        $this->delete("category_id = :category_id", ["category_id" => $id]);
    }
    public function changeStatuss($idParent, $status, $id)
    {
        try {
            $newStatus = $status == 1 ? 0 : 1;
            $parent = $this->selectOne("*", "category_id = :id", ["id" => $idParent]);
            if ($newStatus == 1) { // mở sản phẩm
                if ($parent) { // có parant
                    $statusParent = $parent["status"];
                    if ($statusParent == 0) {
                        return 0;
                        exit();
                    };
                }
            } else {
                if (!$parent) { // đóng sản phẩm
                    $sql = "UPDATE {$this->table} set status = $newStatus where category_id = $id or parent_id = $id";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute();
                    return $stmt->rowCount();
                    exit();
                }
            }
            $sql = "UPDATE {$this->table} set status = $newStatus where category_id = $id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

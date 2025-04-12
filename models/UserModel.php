<?php
class UserModel extends Model
{
    public $table = "users";
    public function getAllUser($conditional = null)
    {
        $sql = "SELECT * FROM users a inner join roles b on a.role_id = b.role_id where b.role_id {$conditional}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $listBanner = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $listBanner;
    }
    
    
}

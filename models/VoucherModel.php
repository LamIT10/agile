<?php
class VoucherModel extends Model
{
      public $table = "vouchers";
      public function decrease($id)
      {
            $sql = "UPDATE vouchers set quantity = quantity -1 where voucher_id = $id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->rowCount();
      }
      public function addToTableUsedTo($id, $user_id)
      {
            $sql = "INSERT INTO vouchers_was_used (voucher_id,user_id) values ($id,$user_id)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->rowCount();
      }
      public function checkVoucherUsed($id, $user_id)
      {
            $sql = "SELECT * FROM vouchers_was_used where voucher_id = $id and user_id = $user_id";
            $list = $this->selectAll($sql);
            return $list;
      }
      public function checkVoucherUsedByUser($user_id)
      {
            $sql = "SELECT * FROM vouchers_was_used a inner join vouchers b on a.voucher_id = b.voucher_id where user_id = $user_id";
            $list = $this->selectAll($sql);
            return $list;
      }
}

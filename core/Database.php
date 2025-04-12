<?php
class Database
{
    public $conn;
    public function getConnect()
    {
        try {
            $this->conn = new PDO('mysql:host=' . HOST . ';dbname=' . DB_NAME, USERNAME, PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $PDOException) {
            echo "Kết nối thất bại: " . $PDOException->getMessage();
            die;
        }
    }
}

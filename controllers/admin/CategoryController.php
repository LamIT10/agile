<?php
class CategoryController extends Controller
{
    public $category;
    public function __construct()
    {
        $this->loadModel("CategoryModel");
        $this->category = new CategoryModel();
    }
    public function index()
    {
        $category = $this->category->getAllCategory();
        $title = "Danh sách danh mục";
        $content = "admin/category/index";
        $layoutPath = "admin_layout";
        $this->renderView("$layoutPath", "$content", ["title" => $title, "category" => $category]);
    }
    public function add()
    {
        $category = $this->category->select("*");
        $title = "Thêm danh mục";
        $content = "admin/category/add";
        $layoutPath = "admin_layout";
        $this->renderView($layoutPath, $content, ["title" => $title, "category" => $category]);
    }
    public function store()
    {
        try {

            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                throw new Exception("Method not allowed", 405);
            }
            $data = $_POST + $_FILES;
            if ($data['parent_id'] == '') $data['parent_id'] = null;
            $_SESSION['error'] = [];
            if ($data['category_name'] == '' || strlen($data['category_name']) > 40) {
                $_SESSION['error']['category_name'] = 'Tên danh mục không được để trống, độ dài nhỏ hơn 40 kí tự';
            }
            if ($data['parent_id'] != '') {
                $listParent = $this->category->select("category_id");
                $check = 0;
                foreach ($listParent as $key => $value) {
                    if ($value['category_id'] == $data['parent_id']) {
                        $check = 1;
                    }
                }
                if ($check == 0) {
                    $_SESSION['error']['parent_id'] = 'ID danh mục cha không tồn tại';
                }
            }
            if ($data['banner']['size'] > 0) {
                if ($data['banner']['size'] > 2 * 1024 * 1024) {
                    $_SESSION['error']['banner'] = "Dung lượng hình ảnh phải nhỏ hơn 2MB";
                }
                $fileType = $data['banner']['type'];
                $allowType = array("image/jpeg", "image/png", "image/gif", "image/jpg");
                if (!in_array($fileType, $allowType)) {
                    $_SESSION['error']['banner'] = "Định dạng hình ảnh không phù hợp, cho phép jpeg, png, gif, jpg";
                }
            }
            if (
                $data['banner']['size'] > 0
            ) {
                $banner = $_FILES['banner']['name'];
                move_uploaded_file($_FILES['banner']['tmp_name'], "uploads/" . $banner);
            }
            if (!empty($_SESSION['error'])) {
                $_SESSION['data'] = $data;
                throw new Exception("Dữ liệu lỗi");
            }
            $rowCount = $this->category->insert(['category_name' => $data['category_name'], 'parent_id' => $data['parent_id'], 'banner' => $data['banner']['name']]);
            if ($rowCount > 0) {
                unset($_SESSION['data']);
                $_SESSION['success'] = true;
                $_SESSION['message'] = "Thêm danh mục thành công";
                header("location:?role=admin&controller=category");
            } else {
                throw new Exception("Không thêm được");
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
            header("location:?role=admin&controller=category&action=add");
        }
    }

    public function edit()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception("URL thiếu tham số ID", 400);
            }
            $id = $_GET['id'];
            $cate = $this->category->selectOne("*", "category_id = :id", ["id" => $id]);
            if (empty($cate)) {
                throw new Exception("Không tìm thấy user có ID $id", 401);
            }
            $category = $this->category->select("*");
            $categoryDetail = $this->category->getOneCategory($id);
            $title = "Sửa danh mục";
            $content = "admin/category/edit";
            $layoutPath = "admin_layout";
            $this->renderView($layoutPath, $content, ["title" => $title, "category" => $category, "categoryDetail" => $categoryDetail]);
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
            header("location:?role=admin&controller=category");
        }
    }
    public function update()
    {
        try {

            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                throw new Exception("Yêu cầu phương thức phải là POST", 300);
            }
            if (!isset($_GET['id'])) {
                throw new Exception("URL thiếu tham số ID", 999);
            }
            $id = $_GET['id'];
            $cate = $this->category->selectOne("*", "category_id = :id", ["id" => $id]);
            if (empty($cate)) {
                throw new Exception("Không tìm thấy user có ID $id", 301);
            }
            $data = $_POST + $_FILES;
            if ($data['parent_id'] == '') $data['parent_id'] = null;
            $_SESSION['error'] = [];
            if ($data['category_name'] == '' || strlen($data['category_name']) > 40) {
                $_SESSION['error']['category_name'] = 'Tên danh mục không được để trống, độ dài nhỏ hơn 40 kí tự';
            }
            var_dump($data['parent_id']);

            if ($data['parent_id'] != '') {
                $listParent = $this->category->select("category_id");
                var_dump($listParent);
                // die();
                $check = 0;
                foreach ($listParent as $key => $value) {
                    if ($value['category_id'] == $data['parent_id']) {
                        $check = 1;
                    }
                }
                if ($check == 0) {
                    $_SESSION['error']['parent_id'] = 'ID danh mục cha không tồn tại';
                }
            }
            if ($data['banner']['size'] > 0) {
                if ($data['banner']['size'] > 2 * 1024 * 1024) {
                    $_SESSION['error']['banner'] = "Dung lượng hình ảnh phải nhỏ hơn 2MB";
                }
                $fileType = $data['banner']['type'];
                $allowType = array("image/jpeg", "image/png", "image/gif", "image/jpg", "image/webp");
                if (!in_array($fileType, $allowType)) {
                    $_SESSION['error']['banner'] = "Định dạng hình ảnh không phù hợp, cho phép jpeg, png, gif, jpg";
                }
            }

            $banner = $_FILES['banner']['name'];
            if (empty($banner)) {
                $data = ['category_name' => $data['category_name'], 'parent_id' => $data['parent_id']];
            } else {
                move_uploaded_file($_FILES['banner']['tmp_name'], "uploads/" . $banner);
                $data = ['category_name' => $data['category_name'], 'parent_id' => $data['parent_id'], 'banner' => $banner];
            }
            if (!empty($_SESSION['error'])) {
                throw new Exception("Dữ liệu lỗi");
            }
            $rowCount = $this->category->updateCategory($data, $id);
            if ($rowCount > 0) {
                unset($_SESSION['data']);
                $_SESSION['success'] = true;
                $_SESSION['message'] = "Sửa danh mục thành công";
                header("location:?role=admin&controller=category");
            } else {
                throw new Exception("Không sửa được");
            }
        } catch (\Throwable $th) {

            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
            if ($th->getCode() == 999 || $th->getCode() == 301 || $th->getCode() == 300) {
                header("location:?role=admin&controller=category");
                die;
            }
            header("location:?role=admin&controller=category&action=edit&id=" . $_GET['id']);
        }
    }
    public function delete()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception("URL thiếu tham số ID", 400);
            }
            $id = $_GET['id'];
            $cate = $this->category->selectOne("*", "category_id = :id", ["id" => $id]);
            if (empty($cate)) {
                throw new Exception("Không tìm thấy user có ID $id", 401);
            }
            $this->category->deleteCategory($id);
            $_SESSION['success'] = true;
            $_SESSION['message'] = "Xoá thành công";
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
        }
        header("location:?role=admin&controller=category");
    }
    public function show()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception("URL thiếu tham số ID", 400);
            }
            $id = $_GET['id'];
            $cate = $this->category->selectOne("*", "category_id = :id", ["id" => $id]);
            if (empty($cate)) {
                throw new Exception("Không tìm thấy danh mục có ID $id", 401);
            }
            $category = $this->category->getOneCategory($id);
            $title = "Chi tiết danh mục";
            $content = "admin/category/show";
            $layoutPath = "admin_layout";
            $this->renderView("$layoutPath", "$content", ["title" => $title, "category" => $category]);
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
            header("location:?role=admin&controller=category");
        }
    }
    public function changeStatus()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception("URL thiếu tham số ID", 400);
            }
            if (!isset($_GET['status'])) {
                throw new Exception("URL thiếu tham số status", 400);
            }
            $id = $_GET['id'];
            $status = $_GET['status'];
            $cate = $this->category->selectOne("*", "category_id = :id", ["id" => $id]);
            if (empty($cate)) {
                throw new Exception("Không tìm thấy danh mục có ID $id");
            }
            $parentId = $this->category->selectOne("parent_id", "category_id = :id", ["id" => $id]);
            $rowCount = $this->category->changeStatuss($parentId["parent_id"], $status, $id);
            if ($rowCount > 0) {
                $_SESSION['success'] = true;
                $_SESSION['message'] = "Thay đổi trạng thái thành công";
            } else {
                throw new Exception("Danh mục cha đang bị vô hiệu hoá");
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
        }
        header("location:?role=admin&controller=category");
    }
}

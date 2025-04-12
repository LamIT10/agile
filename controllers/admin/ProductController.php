<?php
class ProductController extends Controller
{
    public $product;
    public $category;
    public $variant;
    public $order;
    public function __construct()
    {
        $this->loadModel('CategoryModel');
        $this->category = new CategoryModel();
        $this->loadModel('ProductModel');
        $this->product = new ProductModel();
        $this->loadModel('VariantModel');
        $this->variant = new VariantModel();
        $this->loadModel('OrderModel');
        $this->order = new OrderModel();
    }
    public function index()
    {
        $category = $this->category->select("*", "status = 1");
        $product = $this->product->getAllProduct();
        $title = "Quản lý sản phẩm";
        $content = "admin/product/index";
        $layoutPath = "admin_layout";
        $this->renderView($layoutPath, $content, ["title" => $title, "category" => $category, "product" => $product]);
    }
    public function show()
    {
        $id = $_GET['id'];
        $list = $this->variant->getAllVariant($id);
        $title = "Chi tiết sản phẩm";
        $content = "admin/product/show";
        $layoutPath = "admin_layout";
        $this->renderView($layoutPath, $content, ["title" => $title, "list" => $list]);
    }
    public function add()
    {
        $category = $this->category->select("*", "status = 1");
        $title = "Thêm sản phẩm";
        $content = "admin/product/add";
        $layoutPath = "admin_layout";
        $this->renderView($layoutPath, $content, ["title" => $title, "category" => $category]);
    }
    public function store()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] != 'POST') throw new Exception("Yêu cầu method phải là POST", 405);
            $data = $_POST;
            $image = $_FILES['image'];

            $_SESSION['error'] = [];
            if ($data['product_name'] == '' || strlen($data['product_name']) > 40) {
                $_SESSION['error']['product_name'] = 'Tên sản phẩm không được để trống, độ dài nhỏ hơn 40 kí tự';
            }
            if ($data['category_id'] == '') {
                $_SESSION['error']['category_id'] = 'Yêu cầu chọn danh mục';
            }

            if ($image['size'] > 0) {
                if ($image['size'] > 2 * 1024 * 1024) {
                    $_SESSION['error']['image'] = "Dung lượng hình ảnh phải nhỏ hơn 2MB";
                }
                $fileType = $image['type'];
                $allowType = array("image/jpeg", "image/png", "image/gif", "image/jpg", "image/webp");
                if (!in_array($fileType, $allowType)) {
                    $_SESSION['error']['image'] = "Định dạng hình ảnh không phù hợp, cho phép jpeg, png, gif, jpg, webp";
                }
            } else {
                $_SESSION['error']['image'] = "Yêu cầu chọn hình ảnh";
            }
            if ($data['description'] == '') {
                $_SESSION['error']['description'] = 'Yêu cầu nhập mô tả sản phẩm';
            }
            if (
                $image['size'] > 0
            ) {
                $image = $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);
                $data['image'] = $image;
            }
            if (!empty($_SESSION['error'])) {
                $_SESSION['data'] = $data;
                throw new Exception("Dữ liệu lỗi");
            }
            $row = $this->product->insert($data);
            if ($row > 0) {
                $_SESSION['success'] = true;
                $_SESSION['message'] = "Thành công";
                header("location:?role=admin&controller=product");
            } else {
                throw new Exception("Thêm sản phẩm không thành công");
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
            header("location:?role=admin&controller=product&action=add");
        }
    }
    public function addVariant()
    {
        $title = "Add variant";
        $color = $this->variant->selectAll("SELECT * FROM colors");
        $content = "admin/product/addVariant";
        $layoutPath = "admin_layout";
        $this->renderView($layoutPath, $content, ["title" => $title, "color" => $color]);
    }


    public function edit()
    {
        try {
            if (!$_GET['id']) {
                throw new Exception("URL thiếu tham số ID", 10);
            }
            $id = $_GET['id'];
            $product = $this->product->select("*", "product_id = :product_id", ["product_id" => $id]);
            if (empty($product)) {
                throw new Exception("Không tìm thấy sản phẩm có ID = $id");
            }
            $list = $this->category->select("category_id, category_name", "status = 1");
            $product = $this->product->selectOne("*", "product_id = :id", ["id" => $id]);
            $title = "Chi tiết sản phẩm";
            $content = "admin/product/edit";
            $layoutPath = "admin_layout";
            $this->renderView($layoutPath, $content, ["title" => $title, "list" => $list, "product" => $product]);
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
            header("location:?role=admin&controller=product");
            exit();
        }
    }
    public function update()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] != 'POST') throw new Exception("Yêu cầu method phải là POST", 405);
            $data = $_POST;
            $image = $_FILES['image'];

            $_SESSION['error'] = [];
            if ($data['product_name'] == '' || strlen($data['product_name']) > 40) {
                $_SESSION['error']['product_name'] = 'Tên sản phẩm không được để trống, độ dài nhỏ hơn 40 kí tự';
            }
            if ($data['category_id'] == '') {
                $_SESSION['error']['category_id'] = 'Yêu cầu chọn danh mục';
            }

            if ($image['size'] > 0) {
                if ($image['size'] > 2 * 1024 * 1024) {
                    $_SESSION['error']['image'] = "Dung lượng hình ảnh phải nhỏ hơn 2MB";
                }
                $fileType = $image['type'];
                $allowType = array("image/jpeg", "image/png", "image/gif", "image/jpg", "image/webp");
                if (!in_array($fileType, $allowType)) {
                    $_SESSION['error']['image'] = "Định dạng hình ảnh không phù hợp, cho phép jpeg, png, gif, jpg, webp";
                }
            }
            if ($data['description'] == '') {
                $_SESSION['error']['description'] = 'Yêu cầu nhập mô tả sản phẩm';
            }
            if (
                $image['size'] > 0
            ) {
                $image = $_FILES['image']['name'];
                if (!empty($image)) {
                    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);
                    $data['image'] = $image;
                }
            }
            if (!empty($_SESSION['error'])) {
                $_SESSION['data'] = $data;
                throw new Exception("Dữ liệu lỗi");
            }
            $row = $this->product->update($data, "product_id = :id", ["id" => $_GET['id']]);
            if ($row > 0) {
                $_SESSION['success'] = true;
                $_SESSION['message'] = "Sửa sản phẩm thành công";
                header("location:?role=admin&controller=product");
            } else {
                throw new Exception("Sửa sản phẩm không thành công");
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
            header("location:?role=admin&controller=product&action=edit&id=" . $_GET['id']);
        }
    }
    public function editVariant()
    {
        try {
            if (!$_GET['id']) throw new Exception("URL thiếu tham số ID", 10);
            $id = $_GET['id'];
            $variant = $this->variant->selectOne("*", "variant_id = :id", ["id" => $_GET['id']]);
            if (empty($variant)) throw new Exception("Không tìm thấy biến thể có ID = $id");
            $title = "Chi tiết biến thể";
            $variant = $this->variant->getOneVariant($id);
            $color = $this->variant->getColor();
            $size = $this->variant->getSize();
            $content = "admin/product/editVariant";
            $layoutPath = "admin_layout";
            $this->renderView($layoutPath, $content, ["title" => $title, "id" => $id, "variant" => $variant, "color" => $color, "size" => $size]);
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
            header(('location:?role=admin&controller=product&action=show&id=' . $_GET['product_id']));
            exit();
        }
    }
    public function storeVariant()
    {
        try {
            $dataPost = $_POST;
            $dataPost['product_id'] = $_GET['id'];
            $dataFile = $_FILES;
            if ($dataPost['sale_price'] == '' || $dataPost['sale_price'] < 0 || !is_numeric($dataPost['sale_price'])) {
                $_SESSION['error']['sale_price'] = "Giá khuyến mãi phải là số, không được để trống và lớn hơn 0";
            }
            if ($dataPost['base_price'] == '' || $dataPost['base_price'] < 0 || !is_numeric($dataPost['sale_price'])) {
                $_SESSION['error']['base_price'] = "Giá gốc phải là số, không được để trống và lớn hơn 0";
            }
            if ($dataPost['sale_price'] > $dataPost['base_price']) {
                $_SESSION['error']['sale_price'] = "Giá khuyến mãi phải nhỏ hơn hoặc bằng giá gốc";
            }
            if (!isset($dataPost['variant_main'])) {
                $_SESSION['error']['variant_main'] = "Bạn chưa xác nhận biến thể chính";
            }
            $uniqueMain = $this->variant->select("*", "variant_main = 1 and product_id = :product_id", ['product_id' => $_GET['id']]);
            if (!empty($uniqueMain) && $dataPost['variant_main'] == 1) {
                $_SESSION['error']['variant_main'] = "Sản phẩm này đã có biến thể chính";
            }
            if (!isset($dataPost['color_id'])) {
                $_SESSION['error']['color'] = "Yêu cầu chọn màu";
            }
            if (!isset($dataPost['size_id'])) {
                $_SESSION['error']['size'] = "Yêu cầu chọn size";
            }
            if (isset($dataPost['size_id']) && isset($dataPost['color_id'])) {
                $uniqueVariant = $this->variant->select("*", "color_id = :color_id and size_id = :size_id and product_id = :product_id", ['color_id' => $dataPost['color_id'], 'size_id' => $dataPost['size_id'], 'product_id' => $_GET['id']]);
            }
            if (!empty($uniqueVariant)) {
                $_SESSION['error']['variant'] = "Biến thể này đã tồn tại";
            }
            if (!is_numeric($dataPost['quantity']) || $dataPost['quantity'] < 0) {
                $_SESSION['error']['quantity'] = "Số lượng phải lớn hơn 0";
            }
            if ($dataFile['image_main']['size'] == 0) {
                $_SESSION['error']['image_main'] = "Yêu cầu chọn hình ảnh chính cho biến thể";
            }
            if ($dataFile['image_main']['size'] > 0) {
                if ($dataFile['image_main']['size'] > 2 * 1024 * 1024) {
                    $_SESSION['error']['image_main'] = "Dung lượng hình ảnh phải nhỏ hơn 2MB";
                }
                $typeFile = $dataFile['image_main']['type'];
                $allowType = array("image/jpeg", "image/png", "image/gif", "image/jpg", "image/webp");
                if (!in_array($typeFile, $allowType)) {
                    $_SESSION['error']['image_main'] = "Chọn lại dạng hình ảnh phù hợp, cho phép jpeg, png, gif, jpg, webp";
                }
            }
            if (count($dataFile['image']['name']) != 3) {
                $_SESSION['error']['image'] = "Yêu cầu chọn 3 hình ảnh phụ";
            } else {
                for ($i = 0; $i < count($dataFile['image']['name']); $i++) {
                    if ($dataFile['image']['size'][$i] > 2 * 1024 * 1024) {
                        $_SESSION['error']['image'] = "Dung lượng mỗi hình ảnh phải nhỏ hơn 2MB";
                    }
                    $typeFile = $dataFile['image']['type'][$i];
                    $allowType = array("image/jpeg", "image/png", "image/gif", "image/jpg", "image/webp");
                    if (!in_array($typeFile, $allowType)) {
                        $_SESSION['error']['image'] = "Chọn lại dạng hình ảnh phù hợp, cho phép jpeg, png, gif, jpg, webp";
                    }
                }
            }
            if (!empty($_SESSION['error'])) {
                $_SESSION['data'] = $dataPost;
                throw new Exception("Dữ liệu lỗi");
                exit();
            } else {
                move_uploaded_file($_FILES['image_main']['tmp_name'], "uploads/" . $_FILES['image_main']['name']);
                $dataPost['image_main'] = $_FILES['image_main']['name'];

                $variantIdNew = $this->variant->insert($dataPost);
                $imageLenght = count($_FILES['image']['name']);
                for ($i = 0; $i < $imageLenght; $i++) {
                    $issetImage = $this->variant->find("*", "image_link = :image_link", ["image_link" => $_FILES['image']['name'][$i]], "images");
                    if (($issetImage)) {
                        // check xem trong bảng image đã có ảnh đó hay chưa
                        $imageIdNew[] = $issetImage['image_id']; // có thì lấy đúng id của ảnh để làm image_id cho bản ghi mới của image_variant
                    } else {
                        move_uploaded_file($_FILES['image']['tmp_name'][$i], "uploads/" . $_FILES['image']['name'][$i]);
                        $imageNew = $_FILES['image']['name'][$i];
                        $imageIdNew[] = $this->variant->insert2(['image_link' => $imageNew], "images");
                    }
                }
                $countImage = count($imageIdNew);
                for ($i = 0; $i < $countImage; $i++) {
                    $this->variant->insert2(['variant_id' => $variantIdNew, 'image_id' => $imageIdNew[$i]], "image_variant");
                }
                $_SESSION['success'] = true;
                $_SESSION['message'] = "Thêm mới biến thể thành công";
                header("location:?role=admin&controller=product&action=show&id=" . $_GET['id']);
                exit();
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
            header("location:?role=admin&controller=product&action=addVariant&id=" . $_GET['id']);
            exit();
        }
    }
    public function updateVariant()
    {
        try {
            $dataPost = $_POST;
            $dataFile = $_FILES;
            if (!$_GET['id']) throw new Exception("URL thiếu tham số ID", 10);
            $id = $_GET['id'];
            $product_id = $_GET['product_id'];
            $variant = $this->variant->selectOne("*", "variant_id = :id", ["id" => $_GET['id']]);
            if (empty($variant)) throw new Exception("Không tìm thấy biến thể có ID = $id", 11);
            if ($dataPost['sale_price'] == '' || $dataPost['sale_price'] < 0 || !is_numeric($dataPost['sale_price'])) {
                $_SESSION['error']['sale_price'] = "Giá khuyến mãi phải là số, không được để trống và lớn hơn 0";
            }
            if ($dataPost['base_price'] == '' || $dataPost['base_price'] < 0 || !is_numeric($dataPost['sale_price'])) {
                $_SESSION['error']['base_price'] = "Giá gốc phải là số, không được để trống và lớn hơn 0";
            }
            if ($dataPost['sale_price'] > $dataPost['base_price']) {
                $_SESSION['error']['sale_price'] = "Giá khuyến mãi phải nhỏ hơn hoặc bằng giá gốc";
            }
            $uniqueMain = $this->variant->select("*", "variant_main = 1 AND variant_id != :variant_id AND product_id = :product_id", ['variant_id' => $_GET['id'], 'product_id' => $product_id]);
            if (!empty($uniqueMain) && $dataPost['variant_main'] == 1) {
                $_SESSION['error']['variant_main'] = "Sản phẩm này đã có biến thể chính";
            }
            if (!isset($dataPost['color_id'])) {
                $_SESSION['error']['color'] = "Yêu cầu chọn màu";
            }
            if (!isset($dataPost['size_id'])) {
                $_SESSION['error']['size'] = "Yêu cầu chọn size";
            }
            if (isset($dataPost['size_id']) && isset($dataPost['color_id'])) {
                $uniqueVariant = $this->variant->select("*", "color_id = :color_id and size_id = :size_id and product_id = :product_id and variant_id != :variant_id", ['color_id' => $dataPost['color_id'], 'size_id' => $dataPost['size_id'], 'variant_id' => $id, 'product_id' => $product_id]);
            }
            if (!empty($uniqueVariant)) {
                $_SESSION['error']['variant'] = "Biến thể này đã tồn tại";
            }
            if (!is_numeric($dataPost['quantity']) || $dataPost['quantity'] < 0) {
                $_SESSION['error']['quantity'] = "Số lượng phải lớn hơn 0";
            }
            if ($dataFile['image_main']['size'] > 0) {
                if ($dataFile['image_main']['size'] > 2 * 1024 * 1024) {
                    $_SESSION['error']['image_main'] = "Dung lượng hình ảnh phải nhỏ hơn 2MB";
                }
                $typeFile = $dataFile['image_main']['type'];
                $allowType = array("image/jpeg", "image/png", "image/gif", "image/jpg", "image/webp");
                if (!in_array($typeFile, $allowType)) {
                    $_SESSION['error']['image_main'] = "Chọn lại dạng hình ảnh phù hợp, cho phép jpeg, png, gif, jpg, webp";
                }
            }
            if (($dataFile['image']['size'][0]) > 0) {
                if (count($dataFile['image']['name']) != 3) {
                    $_SESSION['error']['image'] = "Yêu cầu chọn 3 hình ảnh phụ";
                } else {
                    for ($i = 0; $i < count($dataFile['image']['name']); $i++) {
                        if ($dataFile['image']['size'][$i] > 2 * 1024 * 1024) {
                            $_SESSION['error']['image'] = "Dung lượng 3 hình ảnh phải nhỏ hơn 2MB";
                        }
                        $typeFile = $dataFile['image']['type'][$i];
                        $allowType = array("image/jpeg", "image/png", "image/gif", "image/jpg", "image/webp");
                        if (!in_array($typeFile, $allowType)) {
                            $_SESSION['error']['image'] = "Chọn lại dạng hình ảnh phù hợp, cho phép jpeg, png, gif, jpg, webp";
                        }
                    }
                }
            }
            if (!empty($_SESSION['error'])) {
                throw new Exception("Dữ liệu lỗi");
                exit();
            } else {
                if ($dataFile['image_main']['size'] > 0) {
                    move_uploaded_file($_FILES['image_main']['tmp_name'], "uploads/" . $_FILES['image_main']['name']);
                    $dataPost['image_main'] = $_FILES['image_main']['name'];
                }
                $count = $this->variant->update($dataPost, "variant_id = :id", ["id" => $id]);
                if ($dataFile['image']['size'][0] > 0) {
                    $imageLenght = count($_FILES['image']['name']);
                    for ($i = 0; $i < $imageLenght; $i++) {
                        $issetImage = $this->variant->find("*", "image_link = :image_link", ["image_link" => $_FILES['image']['name'][$i]], "images");
                        if (($issetImage)) {
                            // check xem trong bảng image đã có ảnh đó hay chưa
                            $imageIdNew[] = $issetImage['image_id']; // có thì lấy đúng id của ảnh để làm image_id cho bản ghi mới của image_variant
                        } else {
                            move_uploaded_file($_FILES['image']['tmp_name'][$i], "uploads/" . $_FILES['image']['name'][$i]);
                            $imageNew = $_FILES['image']['name'][$i];
                            $imageIdNew[] = $this->variant->insert2(['image_link' => $imageNew], "images");
                        }
                    }
                    $rowCount = $this->variant->delete2("image_variant", "variant_id = :id", ["id" => $id]);
                    $countImage = count($imageIdNew);
                    for (
                        $i = 0;
                        $i < $countImage;
                        $i++
                    ) {
                        $this->variant->insert2(['variant_id' => $id, 'image_id' => $imageIdNew[$i]], "image_variant");
                    }
                }
                $_SESSION['success'] = true;
                $_SESSION['message'] = "Chỉnh sửa biến thể thành công";
                header("location:?role=admin&controller=product&action=show&id=$product_id");
                exit();
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
            if ($th->getCode() == 11 || $th->getCode() == 10) {
                header("location:?role=admin&controller=product&action=show&id=$product_id");
                exit();
            }
            header("location:?role=admin&controller=product&action=editVariant&id=$id&product_id=$product_id");
            exit();
        }
    }
    public function delete()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception("URL thiếu tham số ID", 400);
            }
            $id = $_GET['id'];
            $isInOrder = $this->order->checkProductInOrder($id);
            if (!empty($isInOrder)) {
                throw new Exception("Sản phẩm đang được đặt mua, không thể xoá", 400);
            } else {
                $pro = $this->product->selectOne("*", "product_id = :id", ["id" => $id]);
                if (empty($pro)) {
                    throw new Exception("Không tìm thấy sản phẩm có ID $id", 401);
                }
                $this->product->delete("product_id = :id", ["id" => $id]);
                $_SESSION['success'] = true;
                $_SESSION['message'] = "Xoá sản phẩm thành thành công";
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
        }
        header("location:?role=admin&controller=product");
    }
    public function deleteVariant()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception("URL thiếu tham số ID", 400);
            }
            $id = $_GET['id'];
            $product_id = $_GET['product_id'];
            $isInOrder = $this->order->checkVariantInOrder($id);
            if (!empty($isInOrder)) {
                throw new Exception("Biến thể đang được đặt mua, không thể xoá", 400);
            } else {
                $variant = $this->variant->selectOne("*", "variant_id = :variant_id and product_id = :product_id", ["variant_id" => $id, "product_id" => $product_id]);
                if (empty($variant)) {
                    throw new Exception("Không tìm thấy biến thể có ID $id của sản phẩm có ID $product_id", 401);
                }
                $this->variant->delete("variant_id = :id", ["id" => $id]);
                $_SESSION['success'] = true;
                $_SESSION['message'] = "Xoá biến thể thành thành công";
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
        }
        header("location:?role=admin&controller=product&action=show&id=$product_id");
    }
}

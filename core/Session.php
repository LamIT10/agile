<?php
function getErorr($key)
{
    if (isset($_SESSION['error'][$key])) {
        echo  "<p class='text-danger'>" . $_SESSION['error'][$key] . "</p>";
    }
    return false;
}
function getToast()
{
    if (isset($_SESSION['success'])) {
        if ($_SESSION['success']) {
?>
            <div class="toas" style=" color: white;width: max-content;background-color: #07df00">
                <i class="fa-solid fa-circle-check"></i><?php echo $_SESSION['message']; ?>
            </div>
        <?php
        } else {
        ?>
            <div class="toas" style=" color: white;width: max-content;background-color: red">
                <i class="fa-solid fa-triangle-exclamation"></i><?php echo $_SESSION['message']; ?>
            </div>
<?php
        }
        unset($_SESSION['success'], $_SESSION['message']);
    }
}
function getData($key)
{
    if (isset($_SESSION['data'][$key])) {
        echo "value='" . $_SESSION['data'][$key] . "'";
    }
}
function showInforRecept($key)
{
    if (isset($_SESSION['inforUsedTo'])) {
        return $_SESSION['inforUsedTo'][$key];
    }
}
?>
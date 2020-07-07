<!DOCTYPE html>
<html>
<body>
<form action="" method="post" enctype="multipart/form-data">
    Chọn file để upload:
    <input type="file" name="fileupload">
    <input type="submit" value="Đăng ảnh" name="submit">
</form>

<?php

    if (isset($_POST["submit"])) {

        echo "<pre>";
        var_dump($_FILES['fileupload']);

        //Lấy phần mở rộng của file
        $imageFileType = pathinfo($_FILES["fileupload"]["name"],PATHINFO_EXTENSION);
        $maxFileSize   = 1 * 1024 * 1024; //(bytes)
        //Những loại file được phép upload
        $allowTypes    = array('jpg', 'png', 'jpeg', 'gif');
        $allowUpload   = true;
        //Kiểm tra xem có phải là ảnh
        $checkImage = getimagesize($_FILES["fileupload"]["tmp_name"]);

        if ($checkImage) {
            echo "Đây là file ảnh. <br>";
        } else {
            echo "Không phải file ảnh.<br>";
            $allowUpload = false;
        }

        // Kiểm tra nếu file đã tồn tại thì không cho phép ghi đè
        if (file_exists('./uploads/'.$_FILES["fileupload"]["name"])) {
            echo "File đã tồn tại.<br>";
            $allowUpload = false;
        }

        // Kiểm tra kích thước file upload có quá giới hạn cho phép không
        if ($_FILES["fileupload"]["size"] > $maxFileSize) {
            echo "Không được upload ảnh lớn hơn $maxFileSize (bytes). <br>";
            $allowUpload = false;
        }

        // Kiểm tra kiểu file
        if (in_array($imageFileType,$allowTypes)) {
            echo "Đúng định dạng ảnh!<br>";
        } else {
            echo "Chỉ được upload các định dạng JPG, PNG, JPEG, GIF <br>";
            $allowUpload = false;
        }

        // Check nếu $upload 
        if ($allowUpload) {
            if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], './uploads/'.$_FILES["fileupload"]["name"])) {
                echo "File ". $_FILES["fileupload"]["name"].
                " Đã upload thành công";
            } 

        } else {
            echo "Không upload được file!";
        }
    }

?>
</body>
</html>

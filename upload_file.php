<?php
session_start();

$result = false;

/*echo "<pre>";
var_dump($_FILES);
echo "<pre/>";
die;*/

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!empty($_POST['is_cropper']) && $_POST['is_cropper'] == 'yes'){
        $result = uploadUserFiles();
        if($result){
            echo json_encode([
                'check' => true,
                'info' => 'Cropped image is successfully stored',
            ]);
            return;
        }else{
            echo json_encode([
                'check' => false,
                'error' => 'Something is wrong please try again :):',
            ]);
            return;
        }
    }

    if (!empty($_FILES['user_files']['name'][0])) {
        if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $result = uploadUserFiles();
            if($result){
                $_SESSION['info'] = 'Your files are successfully uploaded';
                return header('Location: prac_20_a.php');
            }else{
                $_SESSION['error'] = 'Something is wrong please try again :):';
                return header('Location: prac_20_a.php');
            }
        } elseif (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $result = uploadUserFiles();
            if($result){
                echo json_encode([
                    'check' => true,
                    'info' => 'Your files are successfully uploaded',
                ]);
                return;
            }else{
                echo json_encode([
                    'check' => false,
                    'error' => 'Something is wrong please try again :):',
                ]);
                return;
            }
        } else {
            $_SESSION['error'] = 'Something is wrong please try again :):';
            return header('Location: prac_20_a.php');
        }
    }else{
        echo json_encode([
            'check' => false,
            'error' => 'There is no file to upload please first upload some files'
        ]);
        return;
    }
}else{
    $_SESSION['error'] = 'Something is wrong please try again :):';
    return header("Location: prac_21_a.php");
}

function uploadUserFiles() : bool {
    $result = false;
    if(is_array($_FILES['user_files']['name'])){
        for ($i = 0; $i < count($_FILES['user_files']['name']); $i++) {
            $result = move_uploaded_file($_FILES['user_files']['tmp_name'][$i], "uploaded_files/" . time() . $_FILES['user_files']['name'][$i]);
        }
    }else{
        $type = $_FILES['user_files']['type'];
        $type = explode('/',$type);
        $type = end($type);
        $result = move_uploaded_file($_FILES['user_files']['tmp_name'], "uploaded_files/" . time().'.'.$type);
    }
    return $result;
}
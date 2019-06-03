<?php header('Access-Control-Allow-Origin: *'); ?>

<?php
if ( 0 < $_FILES['file']['error'] ) 
{
    echo json_encode(array('success' => false, 'message' => $_FILES['file']['error']));
}
else 
{
    $time   =   time();
    move_uploaded_file($_FILES['file']['tmp_name'], 'images/' .$time. $_FILES['file']['name']);
    echo json_encode(array('success' => true, 'message' => "Upload Success" , 'filename' => $time.$_FILES['file']['name']));
}
?>
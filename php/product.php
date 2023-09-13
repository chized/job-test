<?php
$data=[];
$product_name = $_POST["product_name"];
$qty_stock = $_POST["qty_stock"];
$price = $_POST["price"];
$datetime = date('m/d/Y h:i:s a', time());
$total = $qty_stock * $price;

if(file_exists('file.json')) {
    $new_data=fileWriteAppend();
    if(file_put_contents('file.json', $save_data)) {
        $alert = "";
    }
}else{
    $new_data=fileCreateWrite();
    if(file_put_contents('file.json', $new_data));
}

function fileWriteAppend() {
    $saved_data = file_get_contents('file.json');
    
}



// redirect to success page

if (!empty($product_name) && !empty($qty_stock) && !empty($price)){
     $data = array($product_name, $qty_stock, $price, $datetime, $total);
    echo json_encode($data); 
    
    }else{
        echo "invalid";
}

?>
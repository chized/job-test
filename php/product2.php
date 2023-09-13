<?php
$data=[];
$product_name = $_POST["product_name"];
$qty_stock = $_POST["qty_stock"];
$price = $_POST["price"];
$datetime = date('m/d/Y h:i:s a', time());
$total = $qty_stock * $price;

 //$data = array($product_name, $qty_stock, $price, $datetime, $total);
 $data = array(
    'product_name' => $product_name,
    'qty_stock' => $qty_stock,
    'price' => $price,
    'datetime' => $datetime,
    'total' => $total
 );
 
 //Check if neccessary field are empty
if (!empty($product_name) && !empty($qty_stock) && !empty($price)){
   
        if(file_exists('file.json')) {
            $new_data=appendToFile($data);
            if(file_put_contents('file.json', $new_data)) {
                $alert = "Done";
            }
        }else{
            $new_data=createToFile();
            if(file_put_contents('file.json', $new_data)){
                $alert="Done";
            }
        } 
        print_r(json_encode($data)); 
   
   }else{
       echo "invalid";
}   
    //Function to append new data to the already created json file
function appendToFile($data) {
    $saved_data = file_get_contents('file.json');
    $all_array = json_decode($saved_data, true);  
    $all_array[] = $data;
    $new_data = json_encode($all_array);
    return $new_data;    
}
    //Function to create new json file when none exist and then add new data
function createToFile() {
    $file=fopen("file.json","w");
    $all_array=array();
    $all_array[] = $data;
    $new_data = json_encode($all_array);
    fclose($file);
    return $new_data;
}

/* if(isset($_POST['edit'])) {
    $file = 'file.json';
    if($_POST['edit'] == 'fetch_single') {
        $file_data = json_decode(file_get_contents(file),true);
        $key = array_search($_POST[])
    }
} */
?>
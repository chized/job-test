<?php
//Process Ajax request
if(isset($_POST["action"])){
    $file = 'file.json';
    
    if($_POST['action'] == 'Add' || $_POST['action'] == 'Edit'){
        $error = array();
        $data = array();
        $data['id'] = time();        

        if(empty($_POST['product_name'])){
            $error['product_name_error'] = 'Product name is required';
        }else{
            $data['product_name'] = trim($_POST['product_name']);
        }

        if(empty($_POST['qty_stock'])){
            $error['qty_stock_error'] = 'Stock Number is required';
        }else{
            $data['qty_stock'] = trim($_POST['qty_stock']);
        }

        if(empty($_POST['price'])){
            $error['price_error'] = 'Product price is required';
        }else{
            $data['price'] = trim($_POST['price']);
        }        
        $data['total'] = $data['qty_stock'] * $data['price'];
        $data['datetime'] = date('m/d/Y h:i:s a', time());
        if(count($error) > 0){
            $output = array('error' => $error);
        }else{
            $file_data = json_decode(file_get_contents($file), true);
            if($_POST['action'] == 'Add'){
                $file_data[] = $data;
                file_put_contents($file, json_encode($file_data));
                $output = array('success' => 'Product Added');
            }
            if($_POST['action'] == 'Edit'){
                $key = array_search($_POST['id'], array_column($file_data, 'id'));
                $file_data[$key]['product_name'] = $data['product_name'];
                $file_data[$key]['qty_stock'] = $data['qty_stock'];
                $file_data[$key]['price'] = $data['price'];
                file_put_contents($file, json_encode($file_data));

                $output = array(
                    'success'=>'Product Updated'
                );
            }
        }
        echo json_encode($output);
    }

    if($_POST['action'] == 'fetch_single'){
        $file_data = json_decode(file_get_contents($file, true));
        $key = array_search($_POST["id"], array_column($file_data, 'id'));
        echo json_encode($file_data[$key]);
    }

    if($_POST['action'] == 'delete'){
        $file_data = json_decode(file_get_contents($file), true);

        $key = array_search($_POST['id'], array_column($file_data, 'id'));
        unset($file_data[$key]);
        file_put_contents($file, json_encode($file_data));
        echo json_encode(['success' => 'Product Deleted']);
        
    }
    
}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>    
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.js"></script>
    <script src="js/common.js" type="text/javascript"></script> 
</head>
<body>
    <div class="container">
        <h1 class="text-center text-success" >Create, Read, Update, Delete (CRUD) Operations for products</h1>
        <div class="alert alert-success" id="alert" role="alert">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col col-sm-9">Product List</div>
                        <div class="col col-sm-3">
                            <button id="add_product" class="btn btn-success btn-sm float-end">Add</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="product_list">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Product name</th>
                                    <th>Quantity</th>
                                    <th>Price per Item</th>                                    
                                    <th>Total</th>
                                    <th>DateTime Submitted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>                
            </div>
    </div>
    
</body>
</html>

<div class="modal" id="action_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="post" id="product_form">
                <div class="modal-header">
                    <h5 class="modal-title" id="title">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="product_name" class="form-label"></label>
                        <input type="text" name="product_name" id="product_name" class="form-control">
                        <span id="product_name_error" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label for="qty_stock" class="form-label">Quantity</label>
                        <input type="text" name="qty_stock" id="qty_stock" class="form-control">
                        <span id="qty_stock_error" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price per Item</label>
                        <input type="text" name="price" id="price" class="form-control">
                        <span id="price_error" class="text-danger"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="total" id="total">
                    <input type="hidden" name="datetime" id="datetime">
                    <input type="hidden" name="action" id="action" value="add">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                </button>
                <button type="submit" class="btn btn-primary" id="action_button">                    
                </button>
                </div>                
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        //show_products();
        
        //function show_products(){

        var seconds = new Date() / 1000;

        $.getJSON("php/file.json?"+seconds+"", function(data){
            data.sort(function(a,b){
                return b.id - a.id;
            });

                var data_arr = [];
                var i = 0;
                for(var count = 0; count < data.length; count++){
                    i++;
                    var sub_array = {
                        //'index': i,
                        'id': data[count].id,
                        'product_name': data[count].product_name,
                        'qty_stock': data[count].qty_stock,
                        'price': data[count].price,                        
                        'total': data[count].total,
                        'datetime': data[count].datetime,
                        'action': '<button type="button" class="btn btn-info btn-sm edit" data-id="'+data[count].id+'">Edit</button>&nbsp;<button type="button" class="btn btn-danger btn-sm delete" data-id="'+data[count].id+'"> Delete</button>'
                    }

                    data_arr.push(sub_array);
                    console.log(data_arr);
                }

                
                $('#product_list').DataTable({
                    data : data_arr,
                    order : [],
                    columns : [
                        //{ data : "index" },
                        { data: "id" },
                        { data: "product_name" },
                        { data: "qty_stock" },
                        { data: "price"},
                        { data: "total"},
                        { data: "datetime"},                        
                        { data: "action"}
                    ]
                });
               
            });     
        //}    

    $('#add_product').click(function(){
        $('#title').text('Add Product');
        $('#product_form')[0].reset();
        $('#action').val('Add');
        $('#action_button').text('Add');
        $('.text-danger').text('');
        $('#action_modal').modal('show');
    });

    $('#product_form').on('submit', function(event) {
        event.preventDefault();

        $.ajax({
            url:"php/process.php",
            method:"POST",
            data:$('#product_form').serialize(),
            dataType:"JSON",
            beforeSend:function(){
                $('#action_button').attr('disabled', 'disabled');
            },
            success:function(data){
                $('#action_button').attr('disabled', false);
                if(data.error){
                    if(data.error.product_name_error){
                        $('#product_name_error').text(data.error.product_name_error);
                    }
                if(data.error.qty_stock_error){
                    $('#qty_stock_error').text(data.error.qty_stock_error);
                }
                if(data.error.price_error){
                    $('#price_error').text(data.error.price_error);
                }
                }else{
                    $('#alert').html('<div class="alert alert-success">'+data.success+'</div>');

                    $('#action_modal').modal('hide');
                    $('#product_list').DataTable().destroy();
                    $('#product_list').DataTable();                       
                    //show_products();
                    setTimeout(function(){
                        $('#alert').html('');
                    }, 3000);   
                                 
                }
            }
        });
    });
});

$(document).on('click', '.edit', function(){
    var id = $(this).data('id');

    $('#title').text('Edit Product');
    $('#action').val('Edit');
    $('#action_button').text('Edit');
    $('.text-danger').text('');
    $('#action_modal').modal('show');
    console.log(id);
    $.ajax({
        url:"php/process.php",
        method:"POST",
        data:{id:id, action:'fetch_single'},
        dataType:"JSON",
        success:function(data){
            $('#product_name').val(data.product_name);
            $('#qty_stock').val(data.qty_stock);
            $('#price').val(data.price);
            $('#total').val(data.total);
            $('#datetime').val(data.datetime);
            $('#id').val(data.id)
        }
    })

})

$(document).on('click', '.delete', function(){
    var id = $(this).data('id');

    if(confirm("Are you sure you want to delete the product")){
        $.ajax({
            url:"php/process.php",
            method:"POST",
            data:{id:id, action:'delete'},
            dataType:"JSON",
            success:function(data){
                $('#alert').html('<div class="alert alert-success">'+data.success+'</div>');
                $('#product_list').DataTable().destroy();
                $('#product_list').DataTable();
                setTimeout(function(){
                    $('#alert').html('');
                }, 5000);
            }
        });
    }
});
</script>
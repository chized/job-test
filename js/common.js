
$(document).ready(function () {
  appendProductToTable();
});
$(document).ready(function () {
    $('#success_alert').hide();
    
    $("#add_product_form").submit(function (event) {
        //console.log("yet to work");
      var formData = {
        product_name: $("#product_name").val(),
        qty_stock: $("#qty_stock").val(),
        price: $("#price").val(),
      };
      
    let total = qty_stock *= price;
    let datetime = new Date().toJSON();            
    console.log("yet to work");
      $.ajax({
        type: "POST",
        url: "php/product2.php",
        data: formData,
        dataType: "json",
        encode: true,
      }).done(function (formData) {
        $('#success_alert').show();
        console.log(formData);
        window.location.href="index.html";
      });
  
      event.preventDefault();
    });
  });
  
  function appendProductToTable(){
    // First check if a <tbody> tag exists, add one if not
    if ($("#product_table tbody").length == 0) {
        $("#product_table").append("<tbody></tbody>");
      }                            
                      $(document).ready(function () {

                        //Fetch data from json file
                        $.getJSON("php/file.json",
                            function (data) {
                              var product = '';
                              var i = 0;
                          //loop through objects
                          $.each(data, function (key, value) {
                              i++;
                            //connect rows to json data
                            product += '<tr>';
                            product += '<td>' + 
                            i + '</td>';
                            product += '<td>' + 
                              value.product_name + '</td>';
                            product += '<td>' + 
                              value.qty_stock + '</td>';
                            product += '<td>' + 
                              value.price + '</td>';
                            product += '<td>' + 
                              value.datetime + '</td>';
                            product += '<td>' + 
                              value.total + '</td>';
                            product += '<td><button id="edit" type="button" class="btn btn-outline-success m-1 edit"><a href="#">Edit</a></button><button type="button" class="btn btn-outline-danger m-1">Delete</button></td>';    
                            product += '</tr>';                 
                          });
$('#product_table').append(product);
                            });
                      });
  }


  $(document).ready(function () {
    $(".edit").click(function (event) {

      var product_name = $(this).data('product_name');
      console.log("check");

          $.ajax({
          url:"product.php",
          method:"POST",
          data:{product_name:product_name, action:'fetch_single'},
          dataType:"JSON",
          success:function(data) {
              $('#product_name').val(data.product_name);
              $('#qty_stock').val(data.qty_stock);
              $('#price').val(data.price);     
              console.log(data);            
          }
      });

  });
});
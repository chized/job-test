
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
      });
  
      event.preventDefault();
    });
  });
  
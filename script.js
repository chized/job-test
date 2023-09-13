if (window.jQuery) {
    // jQuery is available.

    // Print the jQuery version, e.g. "1.0.0":
    console.log(window.jQuery.fn.jquery);
}
$('#success_alert').hide();
$("#add_product_form").submit(function(event){
    // cancels the form submission
    event.preventDefault();
    submitForm();
});

function submitForm(){
            // Initiate Variables With Form Content

            var product_name = $("#product_name").val();
            var qty_stock = $("#qty_stock").val();
            var price = $("#price").val();
            let total = qty_stock *= price;
            let datetime = new Date().toJSON();
            
            $.ajax({
                type: "POST",
                url: "product.php",       
                data: "formdata",
                dataType: 'json', // Note: dataType is only important for the response
                            // jQuery now expects that your server code
                            // will return json

            // here you need to add the 'json' key
            data: {'json': JSON.stringify(data)},       

            // the success method has different order of parameters      
            //success: function(xhr, status, errorMessage) {
            success: function(data, status, xhr) {
                    alert("response was "+data);
            },
            });
}

function formSuccess(){
    //$( "#successAlert" ).removeClass( "hidden" );
    $('#success_alert').show();
    console($data);
    ///$('#display_product').table('show');
}

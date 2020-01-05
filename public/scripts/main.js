console.log('loading this script');

$(document).ready(function() {
    console.log("ready!");
});

function addProductToCart(product){

    $.ajax({
        url: '/addToCart',
        type: "POST",
        dataType: 'json',
        data: {'product' : product,
            'operation' : 'addToCart'},
        success: function (data) {
            const el = $(".successMessage");
            let totalPrice = 0;
            let totalItems = 0;
            for(let el in data){

                totalItems += data[el]['units'];
                totalPrice += data[el]['units'] * data[el]['price'];
            }
            el.html("Product added successfuly <br>" +
                "Nr of products: " + totalItems + "<br>" +
                "Total price: " + totalPrice);
            el.show();
        }
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        const el = $(".successMessage");
        const jsonResp = jqXHR.responseJSON;
        console.log(jqXHR);
        el.html(jsonResp['text']);
        el.show();
    });
}

function changeUnits(product,unitsToChange,el){
    //const el = $(this);
    $.ajax({
        url: '/modifyUnits',
        type: "POST",
        dataType: 'json',
        data: {'product' : product,
            'inc' : unitsToChange,
            'operation' : 'modifyUnits'},
        success: function (data) {
            console.log(data);
            console.log(el.parent().html())
            el.parent().children(".units").text(data['units']);
        }
    });
}

function removeProductFromCart(product,el){
    $.ajax({
        url: '/removeFromCart',
        type: "POST",
        dataType: 'json',
        data: {'product' : product,
            'operation' : 'removeFromCart'},
        success: function (data) {
            console.log('mere');
            el.remove();
            window.location = "/cart";
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        }
    });
}

function showProductDetails(product) {
    window.location = "/products/" + product['id'];
}

function addProductToCartAndSwap(product){

    $.ajax({
        url: '/addToCart',
        type: "POST",
        dataType: 'application/json',
        data: {'product' : product,
            'operation' : 'addToCart'},
        success: function (data) {
            const el = $(".successMessage");
            let totalPrice = 0;
            let totalItems = 0;
            for(let el in data){

                totalItems += data[el]['units'];
                totalPrice += data[el]['units'] * data[el]['price'];
            }
            el.html("Product added successfuly <br>" +
                "Nr of products: " + totalItems + "<br>" +
                "Total price: " + totalPrice);
            el.show();
        }
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
            const el = $(".successMessage");
            const jsonResp = jqXHR.responseJSON;
            console.log(jqXHR);
            el.html(jsonResp['text']);
            el.show();
        });
    window.location = "/cart";
}

function downloadOrder(orderId) {
    window.location = "/orders/" + orderId + "/download";
}

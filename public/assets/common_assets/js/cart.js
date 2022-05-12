const APP_URL = window.location.origin;

$(document).ready(function(){
    $(document).on('click', '.addToCart', addToCart)
    $(document).on('click', '.removeFromCart', removeFromCart)
    $(document).on('click', '.removeFromCheckout', removeFromCartAndCheckout)
    $(document).on('click', '.alreadyInCart', alreadyInCart)
    $(document).on('click', '.cartstateChange', incrementDecrementCount)
})


function alreadyInCart(){
    alert('অলরেডি কার্ডে যুক্ত আছে')
    return false;
}

// console.log(APP_URL);

function addToCart(e) {

    let 
    elem        = $(this),
    id          = elem.attr('data-productid'),
    cartBadge   = $('.cartvalue');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type    : "post",
        url     : APP_URL + '/add-to-cart',
        data    : { productId: id },
        dataType: 'html',
        cache   : false,
        success : function (items) {

            // <i class=\'fa fa-circle-check\'></i> 

            elem.html('<span>অলরেডি যুক্ত আছে</span>');
            elem.removeClass('addToCart');
            elem.addClass('alreadyInCart');
              
            let products = JSON.parse(items);
            if (!Array.isArray(products)){
                products = Object.entries(products);
            }

            cartBadge.html(products.length || 1);

            if(!elem?.attr('data-detail')){
                setTimeout(function(){
                    open(`${location.origin}/shop/${id}`,'_self')
                },500)
            }


        },
        error   : function (xhr, status, error) {
            console.log("An AJAX error occured: " + status + "\nError: " + error);
        }
    });


} 



function removeFromCart(e) {

    let
    elem        = $(this),
    id          = elem.attr('data-productid'),
    cartBadge   = $('.cartvalue'),
    cartTbody   = $('.cart-tbody'),
    currentTr   = $(document).find(`tr[data-productid="${id}"]`),
    checkoutBtnSection = $('.cart-checkout-footer');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "post",
        url: APP_URL + '/remove-from-cart',
        data: { productId: id },
        dataType: 'html',
        cache: false,
        success: function (items) {

            if (items){

                currentTr.remove();

                if (cartTbody.find(`tr[data-productid]`).length < 1){

                    cartTbody.html(`<tr><td colspan="4">
                                <div class="w-100 alert alert-danger text-center">
                                   <h5>Your cart is Empty</h5>
                                </div>
                            </td></tr>`);

                    checkoutBtnSection.html(`<td colspan="2"></td>
                            <td colspan="2">
                                <a href="${checkoutBtnSection.attr('data-shopuri')}" class="btn btn-danger btn-sm text-decoration-none text-white w-100">কেনাকাটা করুন</a>
                            </td>`);

                    $('.grandTotalSection').remove();
                }

            }


            let products = JSON.parse(items);
            if (!Array.isArray(products)) {
                products = Object.entries(products);
            }

            cartBadge.html(products.length || 0);

            cartOverview();

        },
        error: function (xhr, status, error) {
            console.log("An AJAX error occured: " + status + "\nError: " + error);
        }
    });


} 


function incrementDecrementCount(e) {
    let
    elem        = $(this),
    countElem   = elem.closest('tr').find('.count'),
    ref         = elem.attr('data-increment-type'),
    count       = Number(countElem.text() ?? 0),
    pattern1    = /(plus|increment|increament)/im,
    pattern2    = /(minus|decrement|decreament)/im,
    minCount    = Number(countElem?.attr('data-min') ?? 1),
    maxCount    = Number(countElem?.attr('data-max') ?? 10),
    price       = Number(elem.closest('tr').find('.Sale_Price').attr('data-salesprice') ?? 0);

    if (pattern1.test(ref)) {

        count++;
        if (count > maxCount) count = maxCount;

    } else if (pattern2.test(ref)) {

        count--;
        if (count < minCount) count = minCount;
    }


    countElem.text(count);

    priceCalculation((price * count), elem.closest('tr').find('.subtotal'))

}



function priceCalculation(price, target) {

    let pattern = /^[+-]?\d+(\.\d+)$/im;
    if (pattern.test(price)) {
        price = price.toFixed(3);
    }

    target.text(price);

    cartOverview();

}



function cartOverview() {
    let
    pattern         = /^[+-]?\d+(\.\d+)$/im,
    totalProduct    = 0,
    grandTotal      = 0,
    rows            = $(document).find('.cart-items-details table').find(`tr[data-productid]`),
    cartItemsQty    = [];

    [...rows].forEach(row => {
        let product_id= $(row).find('.count').attr('data-productid');
        let itemCount = Number($(row).find('.count').text() ?? 0);
        let itemPrice = Number($(row).find('.Sale_Price').attr('data-salesprice') ?? 0);
        totalProduct += itemPrice * itemCount;
        let cartQtyObj = { product_id, qty: itemCount };
        cartItemsQty.push(cartQtyObj);
    })


    // console.log(cartItemsQty,'update-cart-qty');


    grandTotal = Number(totalProduct);

    if (pattern.test(totalProduct)) {
        grandTotal = grandTotal.toFixed(3)
    }

    $('#grandTotal').text(grandTotal);

    updateCartQty(cartItemsQty);

}




function removeFromCartAndCheckout(e) {

    let
        elem = $(this),
        id = elem.attr('data-productid'),
        cartBadge = $('.cartvalue'),
        cartTbody = $('.checkout-cart-tbody'),
        currentTr = $(document).find(`tr[data-productid="${id}"]`);

    
    if (cartTbody.find(`tr[data-productid]`).length <= 1) {
        alert('You can\'t delete This Product');
        return false;
    }


    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "post",
        url: APP_URL + '/remove-from-cart',
        data: { productId: id },
        dataType: 'html',
        cache: false,
        success: function (items) {

            if (items) {
                currentTr.remove();
            }

            let products = JSON.parse(items);
            if (!Array.isArray(products)) {
                products = Object.entries(products);
            }

            cartBadge.html(products.length || 0);

            checkoutOverview();

        },
        error: function (xhr, status, error) {
            console.log("An AJAX error occured: " + status + "\nError: " + error);
        }
    });


}




function checkoutOverview() {
    let
        pattern = /^[+-]?\d+(\.\d+)$/im,
        totalProduct = 0,
        grandTotal = 0,
        cartItemsQty=[],
        disCountPrice = Number($('#discount').text() ?? 0),
        rows = $(document).find('.cart-items-details table').find(`tr[data-productid]`);

    [...rows].forEach(row => {
        let product_id = $(row).find('.count').attr('data-productid');
        let itemCount = Number($(row).find('.count').text() ?? 0);
        let itemPrice = Number($(row).find('.Sale_Price').attr('data-salesprice') ?? 0);
        totalProduct += itemPrice * itemCount;
        let cartQtyObj = { product_id, qty: itemCount };
        cartItemsQty.push(cartQtyObj);
    })


    grandTotal = Number(totalProduct) + Number(disCountPrice)

    if (pattern.test(totalProduct)) {
        totalProduct = totalProduct.toFixed(3);
        grandTotal = grandTotal.toFixed(3)
    }

    $('#producterdum').text(totalProduct);
    $('#surbomot').text(grandTotal);

    updateCartQty(cartItemsQty);
}




function updateCartQty(cartItemsQty) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "post",
        url: APP_URL + '/update-cart-qty',
        data: { cartQtys: cartItemsQty },
        dataType: 'html',
        cache: false,
        success: function (items) {
            console.log(items);
        },
        error: function (err) {
            console.log(err);
        }
    })
}
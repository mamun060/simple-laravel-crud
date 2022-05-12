

$(document).ready(function(){
    $(document).on('click', '.addToWish', addToWish)
    $(document).on('click', '.removeFromWish', removeFromWish)
})



function addToWish(e) {

    let 
    elem        = $(this),
    auth_user_id= elem.attr('data-auth'),
    id          = elem.attr('data-productid');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type    : "post",
        url     : APP_URL + '/add-to-wish',
        data: { productId: id, customer_id: auth_user_id },
        dataType: 'html',
        cache   : false,
        success : function (items) {
                
            
            let statusObj = null;
            if (items && JSON.parse(items)){
                statusObj = JSON.parse(items);

            }

            if (statusObj?.success == false){
                open(`${APP_URL}/login`, '_self')
                return false;
            }
            // elem.html('<i class="fa-solid fa-heart-circle-check"></i>');
            elem.removeClass('addToWish');
            elem.addClass('removeFromWish');

        },
        error   : function (xhr, status, error) {
            console.log("An AJAX error occured: " + status + "\nError: " + error);
        }
    });


} 




function removeFromWish(e) {

    let
    elem        = $(this),
    id          = elem.attr('data-productid'),
    auth_user_id= elem.attr('data-auth');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "post",
        url: APP_URL + '/remove-from-wish',
        data: { productId: id, customer_id: auth_user_id},
        dataType: 'html',
        cache: false,
        success: function (items) {

            let statusObj = null;
            if (items && JSON.parse(items)) {
                statusObj = JSON.parse(items);

            }

            if (statusObj?.success == false) {
                open(`${APP_URL}/login`, '_self')
                return false;
            }

            // elem.html(`<i class="fa-solid fa-heart"></i>`);
            elem.removeClass('removeFromWish');
            elem.addClass('addToWish');
            

            let products = JSON.parse(items);
            if (!Array.isArray(products)) {
                products = Object.entries(products);
            }

            elem.parent().parent('.__product-card-parent-wish').remove();

            if ($(document).find('.__product-card-parent-wish').length < 1){

                $('.parentOfWishLish')
                .html(`<div class="alert alert-danger w-100 py-4">
                            <h5>Your Wish List is Empty!</h5>
                        </div>`
                ).removeClass('shopping-card-row')
            } 


            // cartBadge.html(products.length || 0);

        },
        error: function (xhr, status, error) {
            console.log("An AJAX error occured: " + status + "\nError: " + error);
        }
    });


} 


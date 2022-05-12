
let timerId = null;
$(document).ready(function(){
    $(document).on('keyup', '.search-product', mySearch)
    $(document).on('click', 'body', removeSearch)
})


function removeSearch(){
    $('#my-list').empty()
}

function mySearch() {

    let 
    searchInput = $(this),
    query       = searchInput.val().trim();

    console.log("calling ...", query);

    clearTimeout(timerId);

    timerId = setTimeout(()=>{
            
        $.ajax({
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url     : APP_URL +'/search-products',
            method  : "POST",
            data    : { query: query },
            cache   : false,
            success : function (data) {

                $('#my-list').fadeIn();
                $('#my-list').html(data);
                // console.log(data);
            },
            error   : function (error) {
                console.log("An AJAX error occured: " + error);
            }
        })

    },500)
   
}

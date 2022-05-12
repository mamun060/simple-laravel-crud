
function _toastMsg(text = null, icon ='error', timer=2000, button=false){
    swal({
        title: manageTile(icon),
        text,
        icon,
        button,
    });

    setTimeout(() => swal.close(), timer);
}


function manageTile(icon){

    let title='';
    switch (icon) {
        case 'success':
            title = "Well done!";
            break;
        case 'error':
            title = "Error!";
            break;
        case 'info':
            title = "Good Job!";
            break;
    }

    return title;
}


function fieldError(responseJSON, field = "") {
    //_toastMsg(res?.msg,'success');
    if (responseJSON?.errors.hasOwnProperty(field)) {
        _toastMsg(responseJSON?.errors[field][0], 'error');
    }
}


function showModal(selector=null)
{
    if(selector){
        $(selector).modal('show');
    }
}

function hideModal(selector=null)
{
    if(selector){
        $(selector).modal('hide');
    }
}


function ajaxFormToken(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
}


function ajaxRequest(obj, { reload, timer , html }){

    $.ajax({
        ...obj,
        success(res){
            console.log(res);
            if(res?.success){
                _toastMsg(res?.msg ?? 'Success!', 'success');

                if(reload){
                    if(timer){
                        setTimeout(() => {
                            location.reload()
                        }, timer);
                    }else{
                        location.reload()
                    }
                }

                if(res?.data){
                    data = res?.data
                }
            }else{
                _toastMsg(res?.msg ?? 'Something wents wrong!');
            }

            
        },
        error(err){
            // setTimeout(() => {
            //     location.reload()
            // }, 1000);
            console.log(err);
            _toastMsg((err.responseJSON?.msg) ?? 'Something wents wrong!')
        },
    });

}


function globeInit(arr=[]){

    let selectPattern   = /select/gim;
    let datePattern     = /date/gim;

    if(arr.length){
   
        arr.forEach(elem => {

            if(selectPattern.test(elem.type)){
                console.log(selectPattern.test(elem.type));
                const { dropdownParent, selector, selectedVal, width , tags} = elem;
                $(selector).select2({
                    width           : width ?? '100%' ,
                    theme           : 'bootstrap4',
                    tags            : tags ?? false,
                    dropdownParent,
                }).val(selectedVal).trigger('change')
            }
            else if(datePattern.test(elem.type)){
                const { selector, format} = elem;
                $(selector).datepicker({
                    autoclose       : true,
                    clearBtn        : false,
                    todayBtn        : true,
                    todayHighlight  : true,
                    orientation     : 'bottom',
                    format          : format ?? 'yyyy-mm-dd',
                })
            }
        });
    }
}



function fileRead(elem, src = '#img-preview') {
    if (elem.files && elem.files[0]) {
        let FR = new FileReader();
        FR.addEventListener("load", function (e) {
            $(document).find(src).attr('src', e.target.result);
        });

        FR.readAsDataURL(elem.files[0]);
    }
}      


function fileToUpload(selector = '#img-preview', defaultSrc=false) {
    const pattern = /base64/im;

    if (defaultSrc){
        $(document).find(selector).attr('src', defaultSrc);  
    }
    
    const file    = $(document).find(selector).attr('src');
    return pattern.test(file) ? file : null;
}




function capitalize(str=""){
    return str.replace('_', ' ').split(' ').map(x => {
        return (x.charAt(0).toUpperCase() + x.substr(1, x.length))
    }).join(' ')
}



function activeNavMenu(){

    let isActive = false;
    const navBarParent = $(document).find('#navbarSupportedContent');
    const navItems = navBarParent.find('.nav-item');
    navItems.removeClass('active');

    [...navItems].forEach(item => {

        if ($(item).find('.nav-link').attr('href') == (window.location.href)){
            $(item).addClass('active');
            isActive = true;
        }
    })


    if (!isActive){
        navBarParent.find('.nav-item:nth-child(1)').addClass('active');
    }
}


function loadMoreItems(){

    let 
    elem            = $(this),
    max_id          = elem.attr('data-maxid'),
    limit           = elem.attr('data-limit');
    containerLoader = $(document).find('.loadMoreContainer'),
    uri             = elem.data('uri'),
    targetTo        = elem.parent(),
    method          = elem?.data('method') ?? 'GET',
    totalCount      = containerLoader?.attr('data-totalcount');
    dataInsertElem  = $(document).find('[data-insert]'),
    dataInsert      = dataInsertElem.data('insert');

    if (!uri) return false;
    
    ajaxFormToken();

    let objectData = { max_id, limit};

    if (elem?.attr('data-ajax-filter')){
        objectData = { ...filterByData(), max_id, limit }
        method     = "POST";
    }

    $.ajax({
        url     : uri,
        type    : method,
        data    : objectData,
        cache   : false,
        success : function (res) {
            // console.log(res);
            if(res?.html){

                elem.attr('data-maxid', res?.max_id);

                if (res?.isLast || totalCount && Number(res?.totalCount) < Number(limit)) {
                    containerLoader.addClass('d-none');
                }else{
                    containerLoader.removeClass('d-none');
                }

                if (dataInsertElem.length){
                    dataInsertElem[dataInsert](res.html);
                }else{
                    containerLoader.before(res.html);
                }

            }
        },
        error: function (error) {
            console.log(error);
        }
    });

}




function filterByData() {

    let
    category_ids= [],
    colors      = [],
    sizes       = [],
    prices      = null,
    tags        = [],
    filterObj   = {};
    categories  = $(document).find('input[name="category"]:checked'),
    colorElems  = $(document).find('.color_container .color.selected'),
    sizeElems   = $(document).find('.size_container .size.selected'),
    tagElems    = $(document).find('.filterTagName.selected'),
    minPrice    = $('#min-price').text(),
    maxPrice    = $('#max-price').text();

    categories.map((i, cat) => {
        category_ids.push($(cat).val());
    })

    colorElems.map((i, color) => {
        colors.push($(color).attr('data-color'));
    })

    sizeElems.map((i, size) => {
        sizes.push($(size).attr('data-size'));
    })

    prices = {
        minPrice,
        maxPrice
    };

    tagElems.map((i, tag) => {
        tags.push($(tag).attr('data-tag'));
    })

    filterObj = {
        category_ids: category_ids,
        colors: colors,
        sizes: sizes,
        prices: prices,
        tags: tags
    };

    return filterObj;
}




function loadMoreLogos() {

    let
    elem            = $(this),
    max_id          = elem.attr('data-maxid'),
    limit           = elem.attr('data-limit');
    containerLoader = $(document).find('.loadMoreContainerlogos'),
    uri             = elem.data('uri'),
    totalCount      = containerLoader?.attr('data-totalcount');

    if (!uri) return false;

    ajaxFormToken();

    let objectData = { max_id, limit };

    $.ajax({
        url : uri,
        type: "POST",
        data: objectData,
        cache: false,
        success: function (res) {
            // console.log(res);
            if (res?.html) {

                elem.attr('data-maxid', res?.max_id);

                if (res?.isLast || totalCount && Number(res?.totalCount) < Number(limit)) {
                    containerLoader.addClass('d-none');
                } else {
                    containerLoader.removeClass('d-none');
                }

                $('.loadMoreContainerlogosparent').append(res.html);

            }
        },
        error: function (error) {
            console.log(error);
        }
    });

}



function trackStatusRender(data){
    let statusBar = "";

    if ( data.status == 'pending'){
        statusBar = `<div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span
                                    class="text">Order Pending</span> </div>
                            <div class="step"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Order
                                    Confirmed</span> </div>
                            <div class="step"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Order
                                    Processing </span> </div>
                            <div class="step"> <span class="icon"> <i class="fa fa-check"></i> </span> <span
                                    class="text">Delivered</span> </div>`;
    } else if(data.status == 'confirm'){
        statusBar = `<div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span
                                    class="text">Order Pending</span> </div>
                            <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span
                                    class="text">Order Confirmed</span> </div>
                            <div class="step"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Order
                                    Processing </span> </div>
                            <div class="step"> <span class="icon"> <i class="fa fa-check"></i> </span> <span
                                    class="text">Delivered</span> </div>`;
    } else if(data.status == 'processing'){
        statusBar = `<div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span
                                    class="text">Order Pending</span> </div>
                            <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span
                                    class="text">Order Confirmed</span> </div>
                            <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span
                                    class="text">Order Processing </span> </div>
                            <div class="step"> <span class="icon"> <i class="fa fa-check"></i> </span> <span
                                    class="text">Delivered</span> </div>`;
    } else if ( data.status == 'completed'){
        statusBar = `<div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span
                                    class="text">Order Pending</span> </div>
                            <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span
                                    class="text">Order Confirmed</span> </div>
                            <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span
                                    class="text">Order Processing </span> </div>
                            <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span
                                    class="text">Delivered </span> </div>`;
    }


    return statusBar;
}


$(document).ready(function(){
    $("body").tooltip({ selector: '[data-bs-toggle=tooltip]' });
});



function activeNavMenuDashboard() {

    let isActive = false;
    const navBarParent = $(document).find('#accordionSidebar');
    const navItems = navBarParent.find('.collapse-item');
    navItems.removeClass('active-nav-item');

    [...navItems].forEach(item => {

        if ($(item).attr('href') == (window.location.href)) {
            $(item).parent().parent().addClass('show');
            $(item).parent().parent().parent().find('.collapsed').addClass('active-nav-item').removeClass('collapsed');
            $(item).addClass('active-nav-item-child');
            isActive = true;
        }
    })


    const navItems2 = navBarParent.find('.nav-item');
    navItems2.removeClass('active-nav-item');

    if (!isActive){
        [...navItems2].forEach(item => {
    
            $(item).removeClass('active');

            if ($(item).find('.nav-link').attr('href') == (window.location.href)) {
                $(item).addClass('active-nav-item');
                $(item).addClass('active');
                isActive = true;
            }
        })
    }



    if (!isActive) {
        navBarParent.find('#accordionSidebar .active').addClass('active');
    }
}


activeNavMenuDashboard();

var mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () { scrollFunction() };

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        mybutton.style.display = "block";
        $("nav").addClass("sticky");
    } else {
        mybutton.style.display = "none";
        $("nav").removeClass("sticky");
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}




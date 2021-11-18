$('.close.icon').on('click', function () {
    $(this).parent().transition('fade');
});

function del() {
    alert("Are you sure you want to delete this record?");
}

$("#search-box").keyup(function () {
    var value = $(this).val();
    console.log(value);
    $.ajax({
        type: "POST",
        url: "/search/job",
        data: {search: value},
        success: function (response) {
            $('.list').html(response.searchJob);
        },
        error: function (response) {
        }
    });
});

$(document).ready(function(){
    let endpoint = 'https://api.spotify.com/v1/artists/0TnOYISbd1XYRBk9myaseg/albums?limit=10&offset=5'
    let token = 'BQDVKd0-7IZTigJ3M9zg41k_IqiUefQ4pIo_y8U2PUwjVF69ybMGHft2pex5Qf2bkPngmR2CgIp9HroJ4RgzXYsmH9Oce4ZziLYiksGqDNTOtFytqPSceUDcqnHdRV4yPxjWFq1qIqXr7qkCi7cECuF8wtvhQHM'


    $('.your-class').slick({
        dots: true,
        infinite: true,
        arrows: true,
        fade: true,
        autoplay: true,
        speed: 300
    });

    $('.slick-next').css('background','black');
    $('.slick-prev').css('background','black');

    $('.slick-next').onclick(function(){
        $.ajax({
            url: endpoint + "?token="+token +"&q=" + $(this).text(),
            contentType: "application/json",
            dataType: 'json',
            success: function(result){
                console.log(result);
            }
        })
    });
});
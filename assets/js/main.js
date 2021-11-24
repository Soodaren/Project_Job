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
    let token = 'BQAT5X03qG8iNGbQfUYe1MpaowK1VEHqhFNrO6bb3T845OeqxLQdlg6fdW1QGy9A2Nd5FP5JpzKQfunkB_xvjdR4Du2eOt91R7SesJQSIP3SS8ODUAda-uDncQSA7ER4Pme5p_-L8JGntmBYslHK8B3GHwKr5D0'

    $('.your-class').slick({
        dots: true,
        infinite: true,
        arrows: true,
        fade: true,
        autoplay: true,
        speed: 300
    });

    $('.slick-next').css({'background':'whitesmoke', 'color': 'black'});
    $('.slick-prev').css({'background':'whitesmoke'});

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
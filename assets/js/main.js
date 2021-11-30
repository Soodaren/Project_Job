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
    let token = 'BQAY7Gg5Xo6tyq_4_YerXS06CGtUWXBBGgZ5OZVI8dB9Spg46cUTqbhc_fSPqLSLUad5yf8dnjcwTpIq1pRUTAv7qHH8jslx6VbV18CFwP4vJR_4Wo6TSH3YhpJqNNTzavVj-XS_cJYTGs6vDPhR-6Kq78NttTY'

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
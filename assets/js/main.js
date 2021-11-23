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
    let token = 'BQBUN30eyiDYjn5IG4Oi-ktuEAX4SovL-nENFfkXIsA7bgi-59r2nNLzosF7DpmDKGQzXS_QPT-MzRkjO1a1Q7RFH6JmcvJPAEUTDBdMUM0jZoS1crekURLRPf1og8mkHpYbW9V6MZlkujZS2hmziKBZg_Tq-iA'

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
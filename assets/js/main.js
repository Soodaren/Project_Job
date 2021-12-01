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

$(document).ready(function () {
    let endpoint = 'https://api.spotify.com/v1/artists/0TnOYISbd1XYRBk9myaseg/albums?limit=10&offset=5'
    let token = 'BQCJefI9kiAUvAgZxVl5ZCIgL7cXTrKK9nfq9HbaP738IlEbBVb5r7riYvNlaYAyewdQ0i9Bi51-vz7h652532CAmPk-y6J3ygYeWRV8MoQ6BQUj2qEBtMW7MawS4JaBQ97iYN4BZO8KH5NjPVdQfqE0xfAR_as'

    $('.your-class').slick({
        dots: true,
        infinite: true,
        arrows: true,
        fade: true,
        autoplay: true,
        speed: 300
    });

    $('.slick-next').onclick(function () {
        $.ajax({
            url: endpoint + "?token=" + token + "&q=" + $(this).text(),
            contentType: "application/json",
            dataType: 'json',
            success: function (result) {
                console.log(result);
            }
        })
    });
});
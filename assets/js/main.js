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
    let yClass = $('.your-class');

    yClass.slick({
        infinite: true,
        slidesToShow: 4,
        speed: 300,
        centerMode: true,
        // variableWidth: true
    });

    yClass.append($('.slick-prev'))
    yClass.append($('.slick-next'))

});
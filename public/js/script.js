window.onscroll = function() { myFunction() };

function myFunction() {
    //on peut  trouver tout les éléments
    //qui ont la class articles
    //stocker tout ca dans une variable
    //puis faire boucler pour faire apparaitre l'article a la bonne
    // valeur de scroll
    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        if (window.innerWidth > 50) {
            document.getElementsByClassName("articles")[0].classList.add("slideUp");
        }
    }
    if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300){
        if (window.innerWidth > 300) {
            document.getElementsByClassName("articles")[1].classList.add("slideUp");
        }
    }
}

//je m'assure que mon document soit chargé avant d'utiliser ma fonction
$(document).ready(function () {
$('.article').slice(0 , 3).show();
$('.more').on('click', function () {
    if ($(this).text() === 'voir plus') {
        $('.article').show();
        $(this).text('voir moins');
    }
    else{
        $('.article').slice(3).hide();
        $(this).text('voir plus');
    }
});
$('.article').on('mouseenter', function () {
    $(this).css('border-width', '10px')
});
$('.article').on('mouseleave', function () {
    $(this).css('border-width', '3px')
});

    $('.main-newsletter').on('click', function () {
        $('.modal').addClass('modal-show')

    });
    $('body').on('click', function (e) {
        if(!$('.main-newsletter').is(e.target) &&
            !$('.modal').is(e.target) &&
            $('.modal').has(e.target).length === 0)
        {
            $('.modal').removeClass('modal-show');
        }
    })
});


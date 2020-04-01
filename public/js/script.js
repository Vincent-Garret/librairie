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
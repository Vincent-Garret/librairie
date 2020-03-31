window.onscroll = function() { myFunction() };

function myFunction() {
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
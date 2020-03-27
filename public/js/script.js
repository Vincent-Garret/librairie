window.onscroll = function() { myFunction() };

function myFunction() {
    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        if (window.innerWidth > 50) {
            document.getElementById("articles").classList.add("slideUp");
        }
    }
}
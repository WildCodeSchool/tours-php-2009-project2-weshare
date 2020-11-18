const mybutton = document.getElementById('returnTop');

function scrollFunction() {
    if (document.documentElement.scrollTop > 30) {
      mybutton.style.display = "block";
    } else {
      mybutton.style.display = "none";
    }
  }
  
  //when click on "go top" button, return to the top of the page
  function topFunction() {
      window.scrollTo({top: 0, behavior: 'smooth'});
      //document.documentElement.scrollTop = 0;
  } 
  
  window.addEventListener('scroll', scrollFunction);
  mybutton.addEventListener('click', topFunction);
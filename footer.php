</main>
<footer style="background-color: #002147; color: white; text-align: center; padding: 15px;">
    &copy; 2025 Tours & Travel. All rights reserved. <br>
    <span style="font-size: 0.9em;">Explore | Discover | Experience</span>
</footer>

<script>
let slideIndex = 0;
showSlides();
function showSlides() {
  let slides = document.getElementsByClassName("slide");
  for (let i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) slideIndex = 1;
  slides[slideIndex - 1].style.display = "block";
  setTimeout(showSlides, 3000); // Change image every 3s
}
</script>



</body>
</html>

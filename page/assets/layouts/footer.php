<footer>
        <p class="footer-text">YOUME</p>
        <p class="footer-small">Thanks for attention</p>
        <div class="text-center sosial_logo_footer">
            <i class="icofont-skype" id="icont-footer"></i>
            <i class="icofont-dribbble" id="icont-footer"></i>
            <i class="icofont-behance" id="icont-footer"></i>
            <i class="icofont-linkedin" id="icont-footer"></i>
       </div>
    </footer>

</div>
 
</body>
<script src="js/jquery-3.5.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/mains.js"></script>
<script>

    window.onscroll = function() {myFunction()};

var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}
</script>
</html>



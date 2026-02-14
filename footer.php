<footer class="section footer-section">
    <div class="footer-image">
      <img
        src="https://img.freepik.com/free-photo/construction-works-frankfurt-downtown-germany_1268-20907.jpg?t=st=1724698071~exp=1724701671~hmac=3d0d208e1de28d97c88f6fb47aca1c2dd8136bec8189c8904d70126114d17949&w=900"
        alt="">
    </div>
    <div class="shade"></div>
    <div class="footer-top">
      <div class="container">
        <div class="inner">
          <div class="logo">
            <!-- Galaxy Projects -->

            <img src="./images/logo.png" alt="">
          </div>
        </div>
      </div>
    </div>
    <div class="footer-middle">
      <div class="container">
        <div class="inner">
          <div class="box">
            <h3>Our Address</h3>
            <p>New Baneshwor, Kathmandu</p>
          </div>
          <div class="box">
            <h3>Talk To Us</h3>
            <p>+9994485858, +995383939</p>
          </div>
          <div class="box">
            <h3>Email Us</h3>
            <p>info@galaxyprojects.com.au</p>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <div class="container">
        <div class="inner">
          <div class="box about-box">
            <h3>About Us</h3>
            <p>
              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quibusdam nostrum ea repudiandae dolor, dolorum
              consequatur inventore aut, molestias ducimus ex autem optio aperiam, neque aliquam reprehenderit!
              Voluptate soluta eum laudantium!
            </p>
            <div class="about-icons">
              <a href="https://facebook.com"><i class="fa-brands fa-facebook"></i></a>
              <a href="https://youtube.com"><i class="fa-brands fa-youtube"></i></a>
              <a href="https://tiktok.com"><i class="fa-brands fa-tiktok"></i></a>

            </div>
          </div>
          <div class="box service-box">
            <h3>Our Services</h3>
            <div class="services">
              <a href="">Renovation</a>
              <a href="">Commercial Fitouts</a>
              <a href="">Electricals</a>
              <a href="">Demolitions</a>
              <a href="">Plumbing</a>
              <a href="">Data & Security</a>
              <a href="">Air Conditioning</a>
              <a href="">Fencing</a>
              <a href="">Flooring</a>
              <a href="">Painting</a>

            </div>
          </div>
          <div class="box links-box">
            <h3>Quick Links</h3>
            <div class="services">
              <a href="">Home</a>
              <a href="">About</a>
              <a href="">Services</a>
              <a href="">Portfolio</a>
              <a href="">Contact Us</a>

            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
        <div class="inner">
          Copyright ©2024 | All rights reserved
        </div>
      </div>
    </div>
  </footer>
<div class="small-nav-container">
  <div class="container">
    <?php
    wp_nav_menu(
      array(
        'menu' => 'primary',
        'container' => '',
        'theme_location' => 'primary',
        'items_wrap' => '<ul class="small-nav-inner">%3$s</ul>'
      )
    );
    ?>
  </div>
  <div class="small-nav-close" onclick="onCrossPressed(event)">
    <i class="fa-solid fa-xmark"></i>
  </div>
</div>
<?php
wp_footer();
?>
</body>

</html>
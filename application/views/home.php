<script type="text/javascript"  src="/assets/javascript/home.js"></script>
<div class="hero-unit span8 offset1 welcome_container">
  <div class="row">
    <div class="span5">
      <div class="span5">
        <div id="myCarousel" class="carousel slide">
          <div class="carousel-inner">
            <div class="item active">
              <img src="/assets/images/phone.jpg" alt="">
              <div class="carousel-caption">
                <h4>Rediscover SMS</h4>
                <p>All of your students can text. We help you incorporate this into the class.</p>
              </div>
            </div>
            <div class="item">
              <img src="/assets/images/students.jpg" alt="">
              <div class="carousel-caption">
                <h4>Student engagement</h4>
                <p>We provide you a simple way to keep your students engaged.</p>
              </div>
            </div>
            <div class="item">
              <img src="/assets/images/phone.jpg" alt="">
              <div class="carousel-caption">
                <h4>Study aid</h4>
                <p>Texting can now help you connect with your students, and help them achieve their goals.</p>
              </div>
            </div>
          </div>
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a> 
            <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a> 
        </div>
      </div>
    </div>
      <div class="span3">
	<?php if (!$user_id) { ?>
	  <h1 class="span3">Try Now</h1>
	  <div class="span3" id="registration"></div>
	<?php } ?>
      </div>
  </div>
</div>


<!-- Example row of columns -->
<div class="row">
  <div class="span4 offset2">
    <h2>About</h2>
    <p>In recent years, the use of alternative methods in education has become extremely popular. However, although 87% of public school students have an SMS capable device, the full potential of SMS as an educational tool has not yet been exploited.</p>
    <p><a class="btn" href="#">View details &raquo;</a></p>
  </div>
  <div class="span4">
    <h2>Why Twexter</h2>
    <p>At Twexter, our goal is to allow secondary school teachers to connect with their students through SMS in constructive ways. To achieve this, we provide them with a series of SMS-based educational tools.</p>
    <p><a class="btn" href="#">View details &raquo;</a></p>
  </div>
</div>

<?php
// Include the geolocation logging functionality
require_once('geolocation-logger.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>VeeProductions – Movie Production Company</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: 'Segoe UI', sans-serif;
      line-height: 1.6;
      background: #111;
      color: #fff;
    }
    header {
      background: url('https://images.unsplash.com/photo-1524985069026-dd778a71c7b4?auto=format&fit=crop&w=1600&q=80') no-repeat center center/cover;
      height: 100vh;
      position: relative;
    }
    header::after {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,0.6);
    }
    .hero-text {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 2;
      text-align: center;
    }
    .hero-text h1 {
      font-size: 3rem;
      margin-bottom: 1rem;
      color: #facc15;
    }
    .hero-text p {
      font-size: 1.2rem;
      max-width: 600px;
      margin: 0 auto;
    }
    nav {
      position: absolute;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 3;
    }
    nav a {
      color: #fff;
      margin: 0 15px;
      text-decoration: none;
      font-weight: bold;
      transition: color 0.3s;
    }
    nav a:hover {
      color: #facc15;
    }
    section {
      padding: 60px 20px;
      max-width: 1200px;
      margin: auto;
    }
    .about {
      text-align: center;
    }
    .gallery {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 15px;
    }
    .gallery img {
      width: 100%;
      border-radius: 10px;
    }
    footer {
      background: #000;
      text-align: center;
      padding: 30px 0;
      font-size: 0.9rem;
      color: #888;
    }
  </style>
</head>
<body>

  <header>
    <nav>
      <a href="#about">About</a>
      <a href="#gallery">Gallery</a>
      <a href="#contact">Contact</a>
    </nav>
    <div class="hero-text">
      <h1>VeeProductions</h1>
      <p>Crafting Cinematic Experiences from the Heart of Tamil Nadu</p>
    </div>
  </header>

  <section id="about" class="about">
    <h2>About Us</h2>
    <p style="margin-top: 20px;">
      VeeProductions is a Tamil Nadu-based movie production company, passionate about telling stories that move audiences. From scripting to post-production, we create films that inspire and entertain.
    </p>
  </section>

  <section id="gallery">
    <h2 style="text-align: center; margin-bottom: 20px;">Gallery</h2>
    <div class="gallery">
      <img src="https://images.unsplash.com/photo-1511765224389-37f0e77cf0eb?auto=format&fit=crop&w=600&q=80" alt="Set 1">
      <img src="https://images.unsplash.com/photo-1590608897129-79da92a0ba58?auto=format&fit=crop&w=600&q=80" alt="Set 2">
      <img src="https://images.unsplash.com/photo-1588286840104-8957e163b551?auto=format&fit=crop&w=600&q=80" alt="Set 3">
      <img src="https://images.unsplash.com/photo-1611016194635-a1ebd4c6d3b3?auto=format&fit=crop&w=600&q=80" alt="Set 4">
      <img src="https://images.unsplash.com/photo-1624204381450-236db5c89468?auto=format&fit=crop&w=600&q=80" alt="Set 5">
      <img src="https://images.unsplash.com/photo-1613677361685-e2e9cd6b62a7?auto=format&fit=crop&w=600&q=80" alt="Set 6">
    </div>
  </section>

  <section id="contact" class="about">
    <h2>Contact</h2>
    <p style="margin-top: 20px;">
      Email: contact@veeproductions.com<br>
      Phone: +91 98765 43210<br>
      Location: Chennai, Tamil Nadu
    </p>
  </section>

  <footer>
    &copy; <?php echo date("Y"); ?> VeeProductions. All rights reserved.
  </footer>

</body>
</html>
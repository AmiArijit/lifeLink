<!doctype html>
<html lang="en" dir="ltr"> 
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>lifeLink</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" integrity="sha384-q8+l9TmX3RaSz3HKGBmqP2u5MkgeN7HrfOJBLcTgZsQsbrx8WqqxdA5PuwUV9WIx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
      :root {
        --primary-red: #d62828;
        --text-dark: #222;
        --light-gray: #f8f9fa;
      }

      body {
        font-family: 'Segoe UI', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #fff;
        color: var(--text-dark);
      }

      .hero-section {
        background: linear-gradient(to bottom right, rgba(37, 36, 36, 0.8), rgba(138,0,0,0.8)),
        url('images/home%20page%20blood%20bank%20image.jpeg') center center/cover no-repeat;
        height: 100vh;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        padding: 2rem;
        margin-top: 0;
        padding-top: 0;
      }

      .hero-section h1 {
        font-size: 3rem;
        font-weight: 700;
      }

      .hero-section p {
        font-size: 1.25rem;
        margin-top: 1rem;
        max-width: 600px;
      }

      .hero-section .btn {
        padding: 0.75rem 2rem;
        font-size: 1rem;
        border-radius: 50px;
        margin: 0.5rem;
      }

      .btn-red {
        background-color: #fff;
        color: var(--primary-red);
        border: none;
      }

      .btn-red:hover {
        background-color: #f1f1f1;
      }

      .btn-outline-light {
        border: 2px solid #fff;
        color: #fff;
        background-color: transparent;
      }

      .btn-outline-light:hover {
        background-color: #fff;
        color: var(--primary-red);
      }

      .features-section {
        padding: 4rem 1rem;
        background-color: var(--light-gray);
        text-align: center;
      }

      .features-section h2 {
        font-weight: 600;
        margin-bottom: 2rem;
      }

      .feature-icon {
        font-size: 2.5rem;
        color: var(--primary-red);
        margin-bottom: 1rem;
      }

      .why-section {
        padding: 4rem 1rem;
        background-color: #fff;
      }

      .why-section img {
        border-radius: 10px;
      }

      .impact-section {
        padding: 4rem 1rem;
        text-align: center;
        background-color: var(--light-gray);
      }

      .impact-number {
        font-size: 2.2rem;
        font-weight: bold;
        color: var(--primary-red);
      }

      footer {
        margin-top: 2rem;
      }
      
    </style>
  </head>

  <body>
    <?php require 'partials/_nav.php' ?>

    <!-- Hero Section -->
    <section class="hero-section">
      <h1>Welcome to lifeLink</h1>
      <p>Real-time access to hospital beds and blood availability — right when it matters most.</p>
      <div class="d-flex flex-wrap justify-content-center mt-4">
        <a href="search.php" class="btn btn-outline-light">Check Bed Availability</a>
        <a href="search.php" class="btn btn-light">🔍︎ Track Blood Availability</a>
      </div>
    </section>

    <!-- Features -->
    <section class="features-section container">
      <h2>What We Offer</h2>
      <div class="row justify-content-center g-4">
        <div class="col-md-4">
          <i class="bi bi-hospital feature-icon"></i>
          <h5>Real-time Bed Tracking</h5>
          <p>Access real-time data on available beds across nearby hospitals.</p>
        </div>
        <div class="col-md-4">
          <i class="bi bi-droplet-fill feature-icon"></i>
          <h5>Live Blood Inventory</h5>
          <p>Find available blood units by group, volume, and hospital instantly.</p>
        </div>
        <div class="col-md-4">
          <i class="bi bi-shield-lock feature-icon"></i>
          <h5>Verified Hospital Data</h5>
          <p>All listings are verified for accuracy and timely information.</p>
        </div>
      </div>
    </section>

    <!-- Why Section -->
    <section class="why-section container">
      <div class="row align-items-center g-4">
        <div class="col-md-6">
          <h2>Why Choose lifeLink?</h2>
          <p>Every second matters in an emergency. lifeLink bridges the gap between people in need and the hospitals that can help them — quickly, clearly, and reliably.</p>
          <ul class="list-unstyled">
            <li>✔ Live hospital bed insights</li>
            <li>✔ Blood availability from trusted banks</li>
            <li>✔ Used by 500+ institutions</li>
          </ul>
        </div>
        <div class="col-md-6">
          <img src="images/whylifelink.jpeg" class="img-fluid" alt="Why lifeLink" aspect-ratio=16:9 >
        </div>
      </div>
    </section>

    <!-- Impact Section -->
    <section class="impact-section">
      <div class="container">
        <h2>Our Impact</h2>
        <p class="text-muted mb-4">Changing lives through connected healthcare</p>
        <div class="row g-4">
          <div class="col-md-3">
            <div class="impact-number">500+</div>
            <p>Hospitals Connected</p>
          </div>
          <div class="col-md-3">
            <div class="impact-number">1200+</div>
            <p>Lives Impacted</p>
          </div>
          <div class="col-md-3">
            <div class="impact-number">1500+</div>
            <p>Blood Donations Tracked</p>
          </div>
          <div class="col-md-3">
            <div class="impact-number">24/7</div>
            <p>Emergency Support</p>
          </div>
        </div>
      </div>
    </section>

    <?php require 'partials/_footer.php' ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

  </body>
</html>

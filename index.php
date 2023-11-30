<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/navbar.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous" /> -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <!-- AOS Animate -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="assets/images/coffeeanco.png">
  <title>Homepage</title>
</head>

<body>
  
  <!-- navbar -->
  <?php include 'includes/navbar.php'; ?>
  <!-- End of the navbar section -->

  <div class="container mt-8">
    <div class="pt-28 pb-28 position-relative">
      <div class="row g-16 align-items-center">
        <div class="col-12 col-md-6">
          <div class="mw-md-lg">
            <p class="mb-6 h5 fw-medium text-dark">In pursuit of the perfect cup</p>
            <h2 class="mb-14" style="letter-spacing: -1px;">We create coffee experiences which elevate expectations</h2>
            <div class="row g-4">
              <a class="btn mt-auto w-25 text-success-light shadow fs-12" style="background-color: var(--primaryo-color);"
                href="#about">About Us!</a>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="row justify-content-center">
            <div class="position-relative col-auto">
              <img class="position-absolute top-0 start-0 mt-n12 ms-n12" style="z-index: 1;"
                src="assets/elements/circle-orange.svg" alt="">
              <img class="position-absolute bottom-0 end-0 me-n5 mb-n5" style="z-index: 1;"
                src="assets/elements/dots-blue.svg" alt="">
              <img class="position-relative img-fluid" src="assets/images/oryx_darkroast.png" alt="">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- vendia -->

  <section id="about" class="bg-secondary-dark" style="background-color: #111215 !important;">
    <div class="position-relative">
      <img class="d-none d-lg-block position-absolute top-0 start-0 h-100 img-fluid col-4 col-lg-5"
        src="assets/images/coffeefarmer.png" alt="" style="object-fit: cover;">
      <div class="container pt-lg-60 pb-32 position-relative">
        <div class="mw-5xl ms-auto">
          <div class="row align-items-center">
            <div class="col-12 col-md-4 mb-16 mb-md-0 mt-n64 mt-lg-0">
              <img class="img-fluid d-block w-100 mx-auto mw-xs shadow" src="assets/images/coffeeroaster.png" alt="">
            </div>
            <div class="col-12 col-md-8">
              <div class="mw-md mw-sm-lg mw-xl-2xl mx-auto ps-lg-10">
                <h1 class="h1 text-white mb-6">About us</h1>
                <p class="mw-lg fs-8 fw-light text-light mb-16">Our journey begins at the source, working hand-in-hand
                  with local farmers across the globe who share our passion and dedication to organic farming and
                  sustainable practices. We take pride in selecting only the finest beans, ensuring each batch is
                  harvested at peak ripeness to capture the distinctive tastes and aromas of its origin.</p>
                <div class="button-action">
                  <a class="btn btn-brown" href="products.php">
                    <span class="me-3">Explore Collections</span>
                    <svg width="11" height="12" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M2.95669 1.7573L9.55635 1.7573M9.55635 1.7573L9.55635 8.35696M9.55635 1.7573L1.07107 10.2426"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- navbar -->
  <?php include 'includes/footer.php'; ?>
  <!-- End of the navbar section -->

  <script type="text/javascript" src="assets/js/navbarscript.js"></script>
</body>

</html>
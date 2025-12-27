<?php
include "includes/header.php";
?>

<!-- Page Header Banner
======================= -->
<div class="envent-details-header">
    <div class="page-header" >
    </div>
</div>

<!-- Pastor Details
=================== -->
<section class="event-details-section-1 pt-80px">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-4 d-flex justify-content-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active fw-semibold" aria-current="page">Chaplaincy Coaching</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 d-flex align-items-center flex-column mb-4 mb-lg-0 justify-content-center ">
                <h1 class="text-center page-title fw-medium">Anchored Chaplains LLC – Chaplain Coaching & Guidance </h1>
                <p class="text-dark text-center w-80 pb-2">Our Purpose Anchored Chaplains LLC offers simple and supportive chaplain coaching for those called to serve. We believe in guiding individuals in their journey of spiritual care—whether in ministry, community service, or faith-based leadership.</p>
            </div>
        </div>
    </div>
    <div class="container container-1">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <img src="assets/images/new/img3.jpeg" alt="Blessed">
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-2 col"></div>
            <div class="col-lg-8 col-10">
                <h4 class="fw-medium pb-2">
                    What We Offer
                </h4>
                <p class="pb-4 text-400">Our mission is to equip and commission spirit-led chaplains who are grounded in faith, trained in trauma-informed care, and prepared to meet people where they are—physically, emotionally, and spiritually.</p>
                <br>
                <h4 class="fw-medium pb-2">
                  Who This Is For
                </h4>
                <ul>
                    <li>One-on-one coaching sessions</li>
                    <li>Encouragement and spiritual support</li>
                    <li>Guidance in chaplain roles and responsibilities</li>
                    <li>Help preparing for chaplain opportunities</li>
                    <li>Support for those exploring chaplain ministry</li>
                </ul>
                <br>
                <h4 class="fw-medium pb-2">
                  How to Get Started
                </h4>
                <ul>
                    <li>Reach out via email or phone</li>
                    <li>Set up a coaching session</li>
                    <li>Come with your questions, goals, or just a desire to grow</li>
                </ul>
                <br>
            </div>
            <div class="col-lg-2 col"></div>
        </div>
    </div>
</section>


<!-- Call to Action Section
=========================== -->
<section class="section-4">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="sec4 py-5 d-flex align-items-center justify-content-between">
                        <div class="content d-flex align-items-center gap-4">
                            <img src="assets/images/home1/img-sec4.png" alt="Blessed" data-aos="zoom-in">
                            <h4 class="d-sm-inline-flex text-white mb-0 fw-normal animation-style3" data-aos="flip-up">
                                Let’s walk this journey together with faith, wisdom, and care.
                            </h4>
                        </div>
                        <a href="apply.php" class="btn mt-4 mt-xl-0 btn-white rounded-5 btn-circle-arrow" data-aos="flip-down">
                            <span class="text">Apply Now</span>
                            <span class="bg-transparent ms-2">
                                <i class="size-16" data-feather="arrow-right"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include "components/contact.php";?>

<?php include "includes/footer.php";?>

<style>
.locked-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
}
.locked-content {
    background: rgba(255, 255, 255, 0.1);
    padding: 2rem;
    border-radius: 10px;
    backdrop-filter: blur(5px);
}
.row-cols-1 .card {
    filter: blur(5px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pinInput = document.getElementById('securityPin');
    if (pinInput) {
        pinInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, ''); // Restrict to numbers only
        });
    }
});
</script>
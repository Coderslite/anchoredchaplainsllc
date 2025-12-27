<?php 
session_start();
// include "php/security.php";
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
                        <li class="breadcrumb-item active fw-semibold" aria-current="page">Life Coaching</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 d-flex align-items-center flex-column mb-4 mb-lg-0 justify-content-center ">
                <h1 class="text-center page-title fw-medium">About Anchored Chaplains LLC</h1>
                <p class="text-dark text-center w-80 pb-2">At Anchored Chaplains LLC, we believe that transformation begins from within—and life coaching is one of the powerful tools God uses to help individuals rediscover their purpose, rebuild confidence, and walk boldly in their calling. <br><br>Anchored Life Coaching was born out of a passion to see people not just survive, but thrive—spiritually, emotionally, and personally. Whether you're facing a major transition, healing from past wounds, seeking clarity in your next steps, or simply feeling stuck, we walk with you toward a renewed and empowered life.</p>
                <!-- <div class="icon-top d-flex gap-1">
                    <a href="https://www.facebook.com/" target="_blank" class="text-dark rounded-5 size-50 d-block hover-up"><i class="p-2 fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/" target="_blank" class="text-dark rounded-5 size-50 d-block hover-up"><i class="p-2 fab fa-instagram"></i></a>
                    <a href="https://www.twitter.com/" target="_blank" class="text-dark rounded-5 size-50 d-block hover-up"><i class="p-2 fab fa-pinterest-p"></i></a>
                    <a href="https://dribbble.com/" target="_blank" class="text-dark rounded-5 size-50 d-block hover-up"><i class="p-2 fab fa-twitter"></i></a>
                </div> -->
            </div>
        </div>
    </div>
    <div class="container container-1">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <img src="assets/images/new/bg3.jpg" alt="Blessed">
            </div>
        </div>
    </div>
    <div class="container  mt-5">
        <div class="row">
            <div class="col-lg-2 col"></div>
            <div class="col-lg-8 col-10">
                <h4 class="fw-medium pb-2">
                    Our Approach
                </h4>
                <p class="text-400">We take a Christ-centered, compassionate, and goal-oriented approach to coaching. Our certified life coaches are also chaplains—spirit-led mentors equipped to guide individuals with both practical strategies and spiritual insight. Every session is designed to support, challenge, and equip you to:</p>
                <ul>
                    <li>Clarify your vision and goals</li>
                    <li>Break free from limiting beliefs</li>
                    <li>Strengthen emotional and spiritual resilience</li>
                    <li>Create actionable steps forward</li>
                    <li>Deepen your relationship with God</li>
                </ul>
                <br>
                <h4 class="fw-medium pb-2">
                   Who We Serve
                </h4>
                <p class="text-400">Anchored Life Coaching is open to individuals from all walks of life—whether you are:</p>
                <ul>
                    <li>Transitioning careers or starting over</li>
                    <li>Working through grief, trauma, or burnout</li>
                    <li>Seeking accountability and clarity</li>
                    <li>A ministry leader needing mentorship</li>
                    <li>Or simply in need of a safe, faith-filled space to grow</li>
                    <li>We serve youth, adults, professionals, and those in ministry, offering one-on-one and group sessions.</li>
                </ul>
                <br>
                <h4 class="fw-medium pb-2">
                   Our Mission
                </h4>
                <p class="pb-4 text-400">To provide anchored, Christ-centered life coaching that transforms hearts, renews minds, and empowers lives to move forward in faith and purpose.</p>
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
                               You don’t have to figure it all out alone. We’re here to walk beside you—anchoring you in truth, hope, and God’s promises every step of the way.
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
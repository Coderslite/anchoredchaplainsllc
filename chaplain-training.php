<?php include "includes/header.php";?>

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
                        <li class="breadcrumb-item active fw-semibold" aria-current="page">Chaplaincy Training</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 d-flex align-items-center flex-column mb-4 mb-lg-0 justify-content-center ">
                <h1 class="text-center page-title fw-medium">About Our Chaplaincy Training Program</h1>
                <p class="text-dark text-center w-80 pb-2">At Anchored Chaplains LLC, we believe chaplaincy is more than a title—it is a sacred calling. Our chaplaincy training program is dedicated to preparing individuals who are ready to serve in hospitals, shelters, crisis centers, correctional facilities, community outreach, and beyond. We train compassionate leaders to minister with excellence, integrity, and cultural sensitivity.</p>
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
                <img src="assets/images/new/img2.jpg" alt="Blessed">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col"></div>
            <div class="col-lg-8 col-10">
                <h4 class="fw-medium pb-2">
                    Our Mission
                </h4>
                <p class="pb-4 text-400">Our mission is to equip and commission spirit-led chaplains who are grounded in faith, trained in trauma-informed care, and prepared to meet people where they are—physically, emotionally, and spiritually.</p>
                <br>
                <h4 class="fw-medium pb-2">
                   What Sets Us Apart
                </h4>
                <p class="text-400">Anchored Chaplains LLC offers a unique blend of ministry and professional chaplaincy preparation. Our program includes:</p>
                <ul>
                    <li>Biblically rooted instruction with real-world applications</li>
                    <li>Trauma-informed and culturally relevant training</li>
                    <li>Mentorship from experienced chaplains</li>
                    <li>Flexible formats including in-person, online, and hybrid training</li>
                    <li>Commissioning and credentialing support</li>
                    <li>Whether you're new to ministry or a seasoned servant, our training helps you step into your role with confidence, clarity, and Christ-like compassion.</li>
                </ul>
                <br>
                <h4 class="fw-medium pb-2">
                  Who Should Enroll
                </h4>
                <p class="text-400">Our chaplaincy training is ideal for:</p>
                <ul>
                    <li>Pastors and ministers expanding their outreach</li>
                    <li>Lay leaders and community volunteers</li>
                    <li>Shelter and prison ministry workers</li>
                    <li>Healthcare or crisis workers seeking spiritual care training</li>
                    <li>Anyone called to serve beyond the church walls</li>
                    <li>We welcome students from all denominations who are aligned with biblical principles and the heart of servant leadership.</li>
                </ul>
                <br>
                <h4 class="fw-medium pb-2">
                    Our Commitment
                </h4>
                <p class="pb-4 text-400">At Anchored Chaplains LLC, we walk alongside our students beyond the classroom. We offer continued support, resources, and networking opportunities to empower chaplains for long-term impact.</p>
                <br>
            </div>
            <div class="col-lg-2 col"></div>
        </div>
    </div>
</section>

<!-- Life Coaching Courses
========================= -->
<section class="courses-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="fw-medium">Chaplaincy Training Courses</h2>
                <!-- <p class="text-400 text-dark">Explore our Christ-centered courses designed to empower your spiritual and personal growth. Download resources to support your journey.</p> -->
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php 
            include "admin/php/db_config.php";
            $query=mysqli_query($con, "SELECT * FROM books");
            while($row = mysqli_fetch_assoc($query)){
                ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title fw-medium"><?php echo $row['title'] ?></h5>
                        <a href="uploads/<?php echo $row['name']; ?>" class="btn btn-outline-primary rounded-5" download>Download </a>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
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
                                Your desire to serve is the beginning. Our training will prepare you for the rest.
                            </h4>
                        </div>
                        <a href="#contact" class="btn mt-4 mt-xl-0 btn-white rounded-5 btn-circle-arrow" data-aos="flip-down">
                            <span class="text">Answer the Call</span>
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
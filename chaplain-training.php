<?php 
session_start();
include "includes/header.php";
include "php/session.php";
?>

<!-- Page Header Banner
======================= -->
<div class="envent-details-header">
    <div class="page-header"></div>
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
            <div class="col-12 d-flex align-items-center flex-column mb-4 mb-lg-0 justify-content-center">
                <h1 class="text-center page-title fw-medium">About Our Chaplaincy Training Program</h1>
                <p class="text-dark text-center w-80 pb-2">At Anchored Chaplains LLC, we believe chaplaincy is more than a title—it is a sacred calling. Our chaplaincy training program is dedicated to preparing individuals who are ready to serve in hospitals, shelters, crisis centers, correctional facilities, community outreach, and beyond. We train compassionate leaders to minister with excellence, integrity, and cultural sensitivity.</p>
            </div>
        </div>
    </div>
    <div class="container container-1">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <img src="assets/images/new/bg5.jpg" alt="Blessed">
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-2 col"></div>
            <div class="col-lg-8 col-10">
                <h4 class="fw-medium pb-2">Our Mission</h4>
                <p class="pb-4 text-400">Our mission is to equip and commission spirit-led chaplains who are grounded in faith, trained in trauma-informed care, and prepared to meet people where they are—physically, emotionally, and spiritually.</p>
                <br>
                <h4 class="fw-medium pb-2">What Sets Us Apart</h4>
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
                <h4 class="fw-medium pb-2">Who Should Enroll</h4>
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
                <h4 class="fw-medium pb-2">Our Commitment</h4>
                <p class="pb-4 text-400">At Anchored Chaplains LLC, we walk alongside our students beyond the classroom. We offer continued support, resources, and networking opportunities to empower chaplains for long-term impact.</p>
                <br>
            </div>
            <div class="col-lg-2 col"></div>
        </div>
    </div>
</section>

<!-- Life Coaching Courses
========================= -->
<div class="col-md-8 mx-auto"><?php echo errorMessage(); echo successMessage();?></div>
<section class="courses-section section-padding">
    <?php if(!@$_SESSION['anchoredPin'] || empty(@$_SESSION['anchoredPin'])) { ?>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="fw-medium">Chaplaincy Training Courses</h2>
                <p class="text-400 text-dark">Explore our Christ-centered courses designed to empower your spiritual and personal growth. Download resources to support your journey.</p>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 position-relative">
            <div class="locked-overlay">
                <div class="locked-content text-center">
                    <i class="fas fa-lock fa-3x mb-3 text-primary"></i>
                    <h4 class="text-white fw-medium">Content Locked</h4>
                    <p class="text-white">Please enter your security PIN to access the chaplaincy training courses, certificates, and videos.</p>
                    <button class="btn btn-primary rounded-5" data-bs-toggle="modal" data-bs-target="#pinModal">Unlock Content</button>
                </div>
            </div>
            <?php 
            include "admin-2/php/db_config.php";
            $query = mysqli_query($con, "SELECT * FROM books");
            while($row = mysqli_fetch_assoc($query)) {
            ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-0 course-card">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="card-title mb-0 fw-medium"><?php echo $row['title']; ?></h5>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-file-pdf fa-3x text-primary mb-3"></i>
                        <a href="uploads/<?php echo $row['name']; ?>" class="btn btn-outline-primary rounded-5 px-4" download aria-label="Download <?php echo $row['title']; ?>">
                            <i class="fas fa-download me-2"></i> Download
                        </a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <!-- PIN Modal -->
    <div class="modal fade" id="pinModal" tabindex="-1" aria-labelledby="pinModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-medium" id="pinModalLabel">Enter Security PIN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="php/unlock.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="securityPin" class="mb-2">Security PIN</label>
                            <input type="password" name="pin" class="form-control" id="securityPin" placeholder="Enter your PIN" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-5" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-5">Unlock</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php } else { ?>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="fw-medium">Chaplaincy Training Courses</h2>
                <p class="text-400 text-dark">Explore our Christ-centered courses designed to empower your spiritual and personal growth. Download resources to support your journey.</p>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php 
            include "admin-2/php/db_config.php";
            $query = mysqli_query($con, "SELECT * FROM books");
            while($row = mysqli_fetch_assoc($query)) {
            ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-0 course-card">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="card-title mb-0 fw-medium"><?php echo $row['title']; ?></h5>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-file-pdf fa-3x text-primary mb-3"></i>
                        <a href="uploads/<?php echo $row['name']; ?>" class="btn btn-outline-primary rounded-5 px-4" download aria-label="Download <?php echo $row['title']; ?>">
                            <i class="fas fa-download me-2"></i> Download
                        </a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <?php } ?>
</section>

<!-- Chaplain Certificates
========================= -->
<section class="certificates-section section-padding">
    <?php if(!@$_SESSION['anchoredPin'] || empty(@$_SESSION['anchoredPin'])) { ?>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="fw-medium">Chaplain Certificates</h2>
                <p class="text-400 text-dark">Access your earned chaplaincy certificates to showcase your training and credentials.</p>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 position-relative">
            <div class="locked-overlay">
                <div class="locked-content text-center">
                    <i class="fas fa-lock fa-3x mb-3 text-primary"></i>
                    <h4 class="text-white fw-medium">Content Locked</h4>
                    <p class="text-white">Please enter your security PIN to access the chaplaincy training courses, certificates, and videos.</p>
                    <button class="btn btn-primary rounded-5" data-bs-toggle="modal" data-bs-target="#pinModal">Unlock Content</button>
                </div>
            </div>
            <?php 
            include "admin-2/php/db_config.php";
            $query = mysqli_query($con, "SELECT * FROM certificates");
            while($row = mysqli_fetch_assoc($query)) {
            ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-0 certificate-card">
                    <div class="card-header bg-success text-white text-center">
                        <h5 class="card-title mb-0 fw-medium"><?php echo $row['title']; ?></h5>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-file-pdf fa-3x text-success mb-3"></i>
                        <a href="uploads/<?php echo $row['name']; ?>" class="btn btn-success rounded-5 px-4" download aria-label="Download <?php echo $row['title']; ?>">
                            <i class="fas fa-download me-2"></i> Download
                        </a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <?php } else { ?>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="fw-medium">Chaplain Certificates</h2>
                <p class="text-400 text-dark">Access your earned chaplaincy certificates to showcase your training and credentials.</p>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php 
            include "admin-2/php/db_config.php";
            $query = mysqli_query($con, "SELECT * FROM certificates");
            while($row = mysqli_fetch_assoc($query)) {
            ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-0 certificate-card">
                    <div class="card-header bg-success text-white text-center">
                        <h5 class="card-title mb-0 fw-medium"><?php echo $row['title']; ?></h5>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-file-pdf fa-3x text-success mb-3"></i>
                        <a href="uploads/<?php echo $row['name']; ?>" class="btn btn-success rounded-5 px-4" download aria-label="Download <?php echo $row['title']; ?>" style="background:#198754; text-white">
                            <i class="fas fa-download me-2"></i> Download
                        </a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <?php } ?>
</section>

<!-- YouTube Videos
========================= -->
<section class="videos-section section-padding">
    <?php if(!@$_SESSION['anchoredPin'] || empty(@$_SESSION['anchoredPin'])) { ?>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="fw-medium">Chaplaincy Training Videos</h2>
                <p class="text-400 text-dark">Watch our training videos to deepen your understanding and enhance your chaplaincy skills.</p>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 position-relative">
            <div class="locked-overlay">
                <div class="locked-content text-center">
                    <i class="fas fa-lock fa-3x mb-3 text-primary"></i>
                    <h4 class="text-white fw-medium">Content Locked</h4>
                    <p class="text-white">Please enter your security PIN to access the chaplaincy training courses, certificates, and videos.</p>
                    <button class="btn btn-primary rounded-5" data-bs-toggle="modal" data-bs-target="#pinModal">Unlock Content</button>
                </div>
            </div>
            <?php 
            include "admin-2/php/db_config.php";
            $query = mysqli_query($con, "SELECT * FROM videos");
            $index = 0;
            while($row = mysqli_fetch_assoc($query)) {
            ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title fw-medium"><?php echo $row['title']; ?></h5>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" id="player-<?php echo $index; ?>" width="100%" height="200" src="<?php echo $row['url']; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <?php $index++; } ?>
        </div>
    </div>
    <?php } else { ?>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="fw-medium">Chaplaincy Training Videos</h2>
                <p class="text-400 text-dark">Watch our training videos to deepen your understanding and enhance your chaplaincy skills.</p>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php 
            include "admin-2/php/db_config.php";
            $query = mysqli_query($con, "SELECT * FROM videos");
            $index = 0;
            while($row = mysqli_fetch_assoc($query)) {
            ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title fw-medium"><?php echo $row['title']; ?></h5>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" id="player-<?php echo $index; ?>" width="100%" height="200" src="<?php echo $row['url']; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <?php $index++; } ?>
        </div>
    </div>
    <?php } ?>
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
                        <a href="apply.php" class="btn mt-4 mt-xl-0 btn-white rounded-5 btn-circle-arrow" data-aos="flip-down">
                            <span class="text">Apply</span>
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
<?php if (!@$_SESSION['anchoredPin'] || empty(@$_SESSION['anchoredPin'])) { ?>
.courses-section .row-cols-1 .card,
.certificates-section .row-cols-1 .card,
.videos-section .row-cols-1 .card {
    filter: blur(5px);
}
<?php } ?>
.embed-responsive {
    position: relative;
    overflow: hidden;
    padding-top: 56.25%; /* 16:9 Aspect Ratio */
}
.embed-responsive-16by9 {
    padding-top: 56.25%;
}
.embed-responsive-item {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
.course-card, .certificate-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.course-card:hover, .certificate-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}
.course-card .card-header, .certificate-card .card-header {
    padding: 1rem;
    border-bottom: none;
}
.course-card .card-body, .certificate-card .card-body {
    padding: 1.5rem;
}
.btn-outline-primary, .btn-outline-success {
    transition: background-color 0.3s ease, color 0.3s ease;
}
.btn-outline-primary:hover {
    background-color: #007bff;
    color: #fff;
}
.btn-outline-success:hover {
    background-color: #28a745;
    color: #fff;
}
</style>

<script>
// Load YouTube IFrame Player API
var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

// Global array to store player instances
var players = [];

function onYouTubeIframeAPIReady() {
    document.querySelectorAll('.embed-responsive-item').forEach(function(iframe, index) {
        players[index] = new YT.Player('player-' + index, {
            events: {
                'onStateChange': onPlayerStateChange
            }
        });
    });
}

function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.PLAYING) {
        players.forEach(function(player, index) {
            if (player.getIframe().id !== event.target.getIframe().id) {
                player.pauseVideo();
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const pinInput = document.getElementById('securityPin');
    if (pinInput) {
        pinInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }
});
</script>
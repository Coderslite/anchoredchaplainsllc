<?php include "includes/header.php";?>
<!-- Content Area
================= -->
<main class="fix">

    <!-- Page Header Banner
    ======================= -->
    <section class="page-header" data-background="assets/images/home1/hero-bg-1.png">
        <div class="container">
            <div class="row">
                <h1 class="mb-2 text-white">Contact Us</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <!-- Get In Touch - Section
    =========================== -->
    <section class="section-padding position-relative">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="contact__content">
                        <div class="section-title tg-heading-subheading animation-style3 mb-4">
                            <p class="sub-title fs-5">Contact</p>
                            <h5 class="title tg-element-title ds-5 fw-normal">Get in Touch</h5>
                        </div>
                        <div class="contact__info underlined-bottom d-inline-flex">
                            <ul class="list-wrap">
                                <li class="mb-4">
                                    <div class="icon-1">
                                        <a href="tel:0123456789">
                                            <i class="size-32" data-feather="phone-call"></i>
                                        </a>
                                    </div>
                                    <div class="content">
                                        <p class="title fs-7">Hotline</p>
                                        <a class="fs-5 text-dark" href="tel:2295550109">(229) 555-0109</a>
                                    </div>
                                </li>
                                <li class="mb-4">
                                    <div class="icon-1">
                                        <a href="mailto:info@gmail.com">
                                            <i class="size-32" data-feather="mail"></i>
                                        </a>
                                    </div>
                                    <div class="content">
                                        <p class="title fs-7">Send us an email</p>
                                        <a class="fs-5 text-dark" href="mailto:info@gmail.com">info@Blessed.com</a>
                                    </div>
                                </li>
                                <li class="mb-4">
                                    <div class="icon-1">
                                        <a href="tel:0123456789">
                                            <i class="size-32" data-feather="phone"></i>
                                        </a>
                                    </div>
                                    <div class="content">
                                        <p class="title fs-7">Give us a call</p>
                                        <a class="fs-5 text-dark" href="tel:0123456789">(000) 666 555 444 </a>
                                    </div>
                                </li>
                                <li class="mb-4">
                                    <div class="icon-1">
                                        <a href="https://www.google.com/maps">
                                            <i class="size-32" data-feather="map-pin"></i>
                                        </a>
                                    </div>
                                    <div class="content">
                                        <p class="title fs-7">Address</p>
                                        <a class="fs-5 text-dark" href="https://www.google.com/maps">2118 Thornridge Cir.
                                            Syracuse,<br> Connecticut 35624</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h5 class="ds-5 fw-medium mb-4">Have Any Question?</h5>
                    <div class="contact__form-wrap">
                        <form id="submitForm">
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="text-dark">Your Name*</span>
                                    <div class="form-grp">
                                        <input type="text" name="name" id="name" value="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="text-dark">Email Address*</span>
                                        <div class="form-grp">
                                            <input type="email" name="email" id="email" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="text-dark">Phone Number*</span>
                                        <div class="form-grp">
                                            <input type="tel" name="phone" id="phone" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-grp">
                                    <span class="text-dark">Message*</span>
                                    <textarea name="message" id="message" class="message"></textarea>
                                </div>
                            </div>
                            <div class="form-grp checkbox-grp">
                                <input type="checkbox" name="checkbox" id="checkbox">
                                <label class="text-dark" for="checkbox">I’d like to get news and insights from
                                    us</label>
                                <span class="ms-1 fs-8">(optional)</span>
                            </div>
                            <button type="submit" class="btn btn-full">Send message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="img-bg-contact d-none d-lg-block alltuchtopdown">
            <img src="assets/images/home2/img-bg-sec-2-1.png" alt="Blessed" data-aos="fade-right" data-aos-delay="400" class="aos-init aos-animate img-bg">
        </div>
    </section>

    <!-- Map Section
    ================ -->
    <section class="map-contact">
        <div class="contact-map p-0">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3152.332792000835!2d144.96011341744386!3d-37.805673299999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d4c2b349649%3A0xb6899234e561db11!2sEnvato!5e0!3m2!1sen!2sbd!4v1685027435635!5m2!1sen!2sbd" allowfullscreen loading="lazy"></iframe>
        </div>
    </section>

</main>
<?php include "includes/footer.php";?>

<script>
$(document).ready(function(){
    $("#submitForm").submit(function(e) {
    e.preventDefault();    
    var formData = new FormData(this);
    $.ajax({
        url: 'php/contact.php',
		type: 'POST',
        contentType: false,
        cache: false,
        processData: false,
        data: formData,
        dataType: 'json',
        beforeSend:function(){
            Swal.fire({
            html:'<div style="font-size: 15px; width:4rem; height:4rem;" class="spinner-border"></div>',
            showConfirmButton:false
            });
        
        },
        success: function (data) {
            if(data.trim() == 'success'){
                
                Swal.fire({
                    icon:'success',					
                    html:'<div class=""> Message Successful</div>',
                    showConfirmButton:true,
                    allowOutsideClick:false
                }).then((result) => {
                    location.href="contact.php";	// location.href="";

                })
            }
            else{
                Swal.fire({
                    icon:'error',
                    html:data,
                    allowOutsideClick:false
                });
            }		
        },
        error:function(){
            Swal.fire({
                icon:'error',
                html:'<div>Something went wrong</div>',
                allowOutsideClick:false
            });
        },
    });
});
});
</script>

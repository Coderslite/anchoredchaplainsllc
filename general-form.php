<?php include "includes/header.php";?>
<!-- Page Header Banner
======================= -->
<div class="envent-details-header">
    <div class="page-header" >
    </div>
</div>

    <!-- Get In Touch - Section
    =========================== -->
    <section class="section-padding position-relative" id="contact">
            <div class="container">
        <div class="row">
            <div class="col-12 mb-4 d-flex justify-content-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active fw-semibold" aria-current="page">Service Request</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto">
                    <h5 class="ds-5 fw-medium mb-4 text-center">Service Request Form</h5>
                    <div class="contact__form-wrap">
                        <form id="serviceRequest">
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="text-dark">First Name</span>
                                        <div class="form-grp">
                                            <input type="text" name="fname" id="name" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="text-dark">Last Name</span>
                                        <div class="form-grp">
                                            <input type="text" name="fname" id="name" value="">
                                        </div>
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
                                <div>
                                    <div class="col-md-12">
                                        <span class="text-dark">Business Service*</span>
                                        <div class="form-grp">
                                            <select name="" class="form-control" id="" required>
                                                <option value="">----select service----</option>
                                                <option value="Affiliate Signup">Affiliate Signup</option>
                                                <option value="Business Coaching">Business Coaching</option>
                                                <option value="Chaplain Coaching">Chaplain Coaching</option>
                                                <option value="Chaplain Training">Chaplain Training</option>
                                                <option value="Life Coaching">Life Coaching</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-full">Submit Request</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="img-bg-contact d-none d-lg-block alltuchtopdown">
            <img src="assets/images/home2/img-bg-sec-2-1.png" alt="Blessed" data-aos="fade-right" data-aos-delay="400" class="aos-init aos-animate img-bg">
        </div>
    </section>


<?php include "includes/footer.php";?>


<script>
$(document).ready(function(){
    $("#serviceRequest").submit(function(e) {
    e.preventDefault();    
    var formData = new FormData(this);
    $.ajax({
        url: 'php/service-request.php',
		type: 'POST',
        contentType: false,
        cache: false,
        processData: false,
        data: formData,
        // dataType: 'json',
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
        error:function(e,e,e){
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
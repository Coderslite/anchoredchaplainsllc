<?php include "includes/header.php"; ?>

<!-- Page Title for SEO -->
<title>Apply Now | Sign Up for Programs</title>

<!-- Page Header Banner -->
<div class="envent-details-header">
    <div class="page-header"></div>
</div>

<!-- Hero Section -->
<section class="event-details-section-1 pt-80px pb-0">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-4 d-flex justify-content-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active fw-semibold" aria-current="page">Apply Now</li>
                    </ol>
                </nav>
            </div>

            <div class="col-12 text-center mb-5">
                <h1 class="display-4 fw-bold text-dark mb-4">Apply for Your Program</h1>
                <p class="lead text-dark mx-auto w-75">Take the first step towards transformation. Fill out the application form below to get started with your chosen program.</p>
            </div>
        </div>
    </div>
</section>

<!-- Application Form Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow border-0">
                    <div class="card-body p-4 p-md-5">
                        <h2 class="text-center fw-bold mb-4">Program Application Form</h2>
                        <p class="text-center text-muted mb-5">Please fill out all fields below. We'll contact you within 24-48 hours.</p>
                        
                        <?php
                        // Handle form submission
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            // Collect form data
                            $name = htmlspecialchars(trim($_POST['name']));
                            $email = htmlspecialchars(trim($_POST['email']));
                            $program = htmlspecialchars(trim($_POST['program']));
                            $phone = htmlspecialchars(trim($_POST['phone']));
                            $dob = htmlspecialchars(trim($_POST['dob']));
                            $address = htmlspecialchars(trim($_POST['address']));
                            $message = htmlspecialchars(trim($_POST['message']));
                            
                            // Basic validation
                            $errors = [];
                            
                            if (empty($name)) {
                                $errors[] = "Name is required";
                            }
                            
                            if (empty($email)) {
                                $errors[] = "Email is required";
                            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                $errors[] = "Please enter a valid email address";
                            }
                            
                            if (empty($program)) {
                                $errors[] = "Please select a program";
                            }
                            
                            if (empty($phone)) {
                                $errors[] = "Phone number is required";
                            }

                            if (empty($dob)) {
                                $errors[] = "Date of Birth is required";
                            }

                            if (empty($address)) {
                                $errors[] = "Address is required";
                            }
                            
                            // If no errors, process the application
                            if (empty($errors)) {
                                // Here you would typically:
                                // 1. Save to database
                                // 2. Send email notification
                                // 3. Send confirmation email to applicant
                                
                                // For now, show success message
                                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Application Submitted Successfully!</strong> We will contact you within 24-48 hours regarding your ' . $program . ' application.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                      </div>';
                                
                                // Reset form values for new submission
                                $name = $email = $program = $phone = $message = $address = $dob = '';
                            } else {
                                // Show errors
                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Please fix the following errors:</strong><ul class="mb-0">';
                                foreach ($errors as $error) {
                                    echo '<li>' . $error . '</li>';
                                }
                                echo '</ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                      </div>';
                            }
                        }
                        ?>
                        
                        <form id="apply">
                            <!-- Name -->
                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold">Full Name *</label>
                                <input type="text" class="form-control form-control-lg" id="name" name="name" 
                                       value="<?php echo isset($name) ? $name : ''; ?>" 
                                       placeholder="Enter your full name" required>
                            </div>
                            
                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">Email Address *</label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email" 
                                       value="<?php echo isset($email) ? $email : ''; ?>" 
                                       placeholder="Enter your email address" required>
                            </div>
                            
                            <!-- Program Selection -->
                            <div class="mb-4">
                                <label for="program" class="form-label fw-semibold">Select Program *</label>
                                <select class="form-select form-select-lg" id="program" name="program" required>
                                    <option value="" disabled selected>Choose a program</option>
                                    <option value="Life Coaching" <?php echo (isset($program) && $program == 'Life Coaching') ? 'selected' : ''; ?>>Life Coaching</option>
                                    <option value="Chaplain Training" <?php echo (isset($program) && $program == 'Chaplain Training') ? 'selected' : ''; ?>>Chaplain Training</option>
                                    <option value="Chaplain Coaching" <?php echo (isset($program) && $program == 'Chaplain Coaching') ? 'selected' : ''; ?>>Chaplain Coaching</option>
                                    <option value="Business Coaching" <?php echo (isset($program) && $program == 'Business Coaching') ? 'selected' : ''; ?>>Business Coaching</option>
                                    <option value="Book Coaching" <?php echo (isset($program) && $program == 'Book Coaching') ? 'selected' : ''; ?>>Book Coaching</option>
                                    <option value="Affiliate Program" <?php echo (isset($program) && $program == 'Affiliate Program') ? 'selected' : ''; ?>>Affiliate Program</option>
                                </select>
                                <div class="form-text">Choose the program you're interested in joining</div>
                            </div>
                            
                            <!-- Phone Number -->
                            <div class="mb-4">
                                <label for="phone" class="form-label fw-semibold">Phone Number *</label>
                                <input type="tel" class="form-control form-control-lg" id="phone" name="phone" 
                                       value="<?php echo isset($phone) ? $phone : ''; ?>" 
                                       placeholder="Enter your phone number" required>
                                <div class="form-text">We'll contact you at this number</div>
                            </div>

                            <!-- Address -->
                            <div class="mb-4">
                                <label for="address" class="form-label fw-semibold">Address *</label>
                                <input type="address" class="form-control form-control-lg" id="address" name="address" 
                                       value="<?php echo isset($address) ? $address: ''; ?>" 
                                       placeholder="Enter your Home Address" required>
                            </div>

                            <!-- DOB -->
                            <div class="mb-4">
                                <label for="dob" class="form-label fw-semibold">Date of Birth *</label>
                                <input type="date" class="form-control form-control-lg" id="dob" name="dob" 
                                       value="<?php echo isset($dob) ? $dob: ''; ?>" 
                                       required>
                            </div>
                            
                            <!-- Additional Message -->
                            <div class="mb-4">
                                <label for="message" class="form-label fw-semibold">Additional Information (Optional)</label>
                                <textarea class="form-control" id="message" name="message" rows="4" 
                                          placeholder="Tell us about your goals, experience, or any questions you have..."><?php echo isset($message) ? $message : ''; ?></textarea>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="d-grid mt-5">
                                <button type="submit" class="btn btn-primary btn-lg rounded-5 py-3">
                                    <i class="me-2" data-feather="send"></i> Submit Application
                                </button>
                            </div>
                            
                            <p class="text-center text-muted mt-4">
                                By submitting this form, you agree to be contacted regarding the selected program.
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Programs Overview -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Our Programs</h2>
        <div class="row g-4">
            <!-- Life Coaching -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="text-primary" data-feather="heart" width="24" height="24"></i>
                            </div>
                            <h5 class="card-title mb-0 fw-bold">Life Coaching</h5>
                        </div>
                        <p class="card-text">Transform your personal and professional life with guided coaching sessions focused on clarity, purpose, and growth.</p>
                    </div>
                </div>
            </div>
            
            <!-- Chaplain Training -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="text-primary" data-feather="users" width="24" height="24"></i>
                            </div>
                            <h5 class="card-title mb-0 fw-bold">Chaplain Training</h5>
                        </div>
                        <p class="card-text">Develop the skills and spiritual foundation needed for effective chaplaincy and ministerial support in various settings.</p>
                    </div>
                </div>
            </div>
            
            <!-- Chaplain Coaching -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="text-primary" data-feather="compass" width="24" height="24"></i>
                            </div>
                            <h5 class="card-title mb-0 fw-bold">Chaplain Coaching</h5>
                        </div>
                        <p class="card-text">Ongoing support and guidance for practicing chaplains to enhance their ministry and personal well-being.</p>
                    </div>
                </div>
            </div>
            
            <!-- Business Coaching -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="text-primary" data-feather="briefcase" width="24" height="24"></i>
                            </div>
                            <h5 class="card-title mb-0 fw-bold">Business Coaching</h5>
                        </div>
                        <p class="card-text">Launch and grow your business with practical strategies, systems, and guidance tailored to your unique vision.</p>
                    </div>
                </div>
            </div>
            
            <!-- Book Coaching -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="text-primary" data-feather="book" width="24" height="24"></i>
                            </div>
                            <h5 class="card-title mb-0 fw-bold">Book Coaching</h5>
                        </div>
                        <p class="card-text">Bring your book idea to life with guidance through writing, publishing, and marketing your work.</p>
                    </div>
                </div>
            </div>
            
            
            <!-- Affiliate Program -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="text-primary" data-feather="share-2" width="24" height="24"></i>
                            </div>
                            <h5 class="card-title mb-0 fw-bold">Affiliate Program</h5>
                        </div>
                        <p class="card-text">Partner with us to share our programs and earn commissions while helping others transform their lives.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact CTA -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center bg-primary rounded-4 p-5">
            <div class="col-lg-8 text-white">
                <h2 class="fw-bold mb-3">Questions Before Applying?</h2>
                <p class="lead mb-0">We're here to help! Contact us if you need more information about any program.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="contact.php" class="btn btn-white btn-lg rounded-5 px-4">
                    <i class="me-2" data-feather="message-circle"></i> Contact Us
                </a>
            </div>
        </div>
    </div>
</section>

<?php include "includes/footer.php"; ?>


<script>
$(document).ready(function(){
    $("#apply").submit(function(e) {
    e.preventDefault();    
    var formData = new FormData(this);
    $.ajax({
        url: 'php/apply.php',
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
                    html:'<div class="">Application Successful</div>',
                    showConfirmButton:true,
                    allowOutsideClick:false
                }).then((result) => {
                    location.href="apply.php";	// location.href="";

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
<?php include "includes/header.php";

// Get client ID from URL
$client_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($client_id == 0) {
    echo "<script>alert('Invalid client ID'); window.location='clients.php';</script>";
    exit();
}


// Fetch client information
$client_query = mysqli_query($con, "SELECT * FROM clients WHERE id = $client_id AND status <> 'deleted'");
$client = mysqli_fetch_assoc($client_query);

if(!$client) {
    echo "<script>alert('Client not found'); window.location='clients.php';</script>";
    exit();
}

// Fetch chaplains for dropdown
$chaplains_query = mysqli_query($con, "SELECT * FROM chaplains WHERE status = 'Active'");
?>

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-xl-6 col-sm-7 box-col-3">
                    <div class="d-flex align-items-center">
                        <h3 class="mb-0">Client Profile</h3>
                        <span class="badge bg-<?php echo getStatusColor($client['status']); ?> ms-3">
                            <?php echo $client['status']; ?>
                        </span>
                    </div>
                </div>
                <div class="col-xl-6 col-sm-5 box-col-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">
                                <svg class="stroke-icon"> 
                                    <use href="assets/svg/icon-sprite.svg#stroke-home"></use>
                                </svg>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="clients.php">Clients</a></li>
                        <li class="breadcrumb-item active"><?php echo $client['fullname']; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Container-fluid starts-->
    <div class="container-fluid">
<?php echo ErrorMessage(); echo SuccessMessage();?>

        <div class="user-profile">
            <div class="row">
                <!-- Client Information Card -->
                <div class="col-xl-4 col-lg-5">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h4>Client Information</h4>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editClientModal">
                                <svg width="16" height="16" class="me-1">
                                    <use href="assets/svg/icon-sprite.svg#edit"></use>
                                </svg>
                                Edit
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="client-info mb-4">
                                <div class="text-center mb-4">
                                    <div class="client-avatar position-relative mx-auto mb-3">
                                        <img class="img-fluid rounded-circle" src="assets/images/default.png" 
                                             alt="<?php echo $client['fullname']; ?>" width="120" height="120">
                                        <span class="badge bg-<?php echo getStatusColor($client['status']); ?> position-absolute bottom-0 end-0">
                                            <?php echo $client['status']; ?>
                                        </span>
                                    </div>
                                    <h4 class="mb-1"><?php echo $client['fullname']; ?></h4>
                                    <p class="text-muted mb-0">Client ID: <?php echo $client['id']; ?></p>
                                </div>

                                <div class="info-section">
                                    <h6 class="mb-3 border-bottom pb-2">Personal Details</h6>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <p class="text-muted mb-1">Email</p>
                                            <p class="fw-medium mb-0"><?php echo $client['email']; ?></p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-muted mb-1">Phone</p>
                                            <p class="fw-medium mb-0"><?php echo $client['phone']; ?></p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-muted mb-1">DOB</p>
                                            <p class="fw-medium mb-0"><?php echo $client['dob']; ?></p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-muted mb-1">Address</p>
                                            <p class="fw-medium mb-0"><?php echo $client['address']; ?></p>
                                        </div>
                                    </div>
                                    
                                    <h6 class="mb-3 border-bottom pb-2">Program Details</h6>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <p class="text-muted mb-1">Program Applied</p>
                                            <p class="fw-medium mb-0"><?php echo $client['program_applied']; ?></p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-muted mb-1">Assigned Chaplain</p>
                                            <?php 
                                                $chaplainId = $client['assigned_chaplain'];
                                            if(!empty($chaplainId)){
                                                $q= mysqli_query($con,"SELECT * FROM chaplains WHERE id='$chaplainId'");
                                                $chaplain = mysqli_fetch_assoc($q);
                                                $chaplainName = $chaplain['name'];
                                                echo '<p class="fw-medium mb-0">'.$chaplainName.'</p>';
                                            }?>
                                        </div>
                                    </div>
                                    
                                    <h6 class="mb-3 border-bottom pb-2">Status Timeline</h6>
                                    <div class="timeline-info">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Applied Date</span>
                                            <span class="fw-medium"><?php echo formatDate($client['applied_date']); ?></span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Approved Date</span>
                                            <span class="fw-medium"><?php echo formatDate($client['approved_date']); ?></span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Renewal Date</span>
                                            <span class="fw-medium <?php echo isRenewalDue($client['renewed_date']) ? 'text-warning' : ''; ?>">
                                                <?php echo formatDate($client['renewed_date']); ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <?php if(!empty($client['additional_information'])): ?>
                                    <h6 class="mb-3 border-bottom pb-2 mt-4">Additional Information</h6>
                                    <p class="text-muted"><?php echo $client['additional_information']; ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- File Management Section -->
                <div class="col-xl-8 col-lg-7">
                    <!-- Folders Section -->
                    <?php include "components/client-files.php";?>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>

<?php include "includes/footer.php"; ?>


<!-- Edit Client Modal -->
<div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="editClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editClientModalLabel">Edit Client Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="php/update.php">
                <input type="hidden" name="client_id" value="<?php echo $client_id;?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name *</label>
                            <input type="text" class="form-control" name="fullname" value="<?php echo $client['fullname']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address *</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $client['email']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" name="phone" value="<?php echo $client['phone']; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">DOB</label>
                            <input type="date" class="form-control" name="dob" value="<?php echo $client['dob']; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Address</label>
                            <input type="address" class="form-control" name="address" value="<?php echo $client['address']; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Program Applied</label>
                            <select class="form-select" name="program_applied">
                                <option value="">Select Program</option>
                                <option value="Life Coaching" <?php echo $client['program_applied'] == 'Life Coaching' ? 'selected' : ''; ?>>Life Coaching</option>
                                <option value="Chaplain Training" <?php echo $client['program_applied'] == 'Chaplain Training' ? 'selected' : ''; ?>>Chaplain Training</option>
                                <option value="Chaplain Coaching" <?php echo $client['program_applied'] == 'Chaplain Coaching' ? 'selected' : ''; ?>>Chaplain Coaching</option>
                                <option value="Business Coaching" <?php echo $client['program_applied'] == 'Business Coaching' ? 'selected' : ''; ?>>Business Coaching</option>
                                <option value="Book Coaching" <?php echo $client['program_applied'] == 'Book Coaching' ? 'selected' : ''; ?>>Book Coaching</option>
                                <option value="Affiliate Program" <?php echo $client['program_applied'] == 'Affiliate Program' ? 'selected' : ''; ?>>Affiliate Program</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Assigned Chaplain</label>
                            <select class="form-select" name="assigned_chaplain">
                                <option value="">Select Chaplain</option>
                                <?php while($chaplain = mysqli_fetch_assoc($chaplains_query)): ?>
                                <option value="<?php echo $chaplain['id']; ?>" <?php echo $client['assigned_chaplain'] == $chaplain['name'] ? 'selected' : ''; ?>>
                                    <?php echo $chaplain['name']; ?>
                                </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="Active" <?php echo $client['status'] == 'Active' ? 'selected' : ''; ?>>Active</option>
                                <option value="Pending" <?php echo $client['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="Completed" <?php echo $client['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                <option value="Inactive" <?php echo $client['status'] == 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Applied Date</label>
                            <input type="date" class="form-control" name="applied_date" value="<?php echo $client['applied_date']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Approved Date</label>
                            <input type="date" class="form-control" name="approved_date" value="<?php echo $client['approved_date']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Renewal Date</label>
                            <input type="date" class="form-control" name="renewed_date" value="<?php echo $client['renewed_date']; ?>">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Additional Information</label>
                            <textarea class="form-control" name="additional_information" rows="3" placeholder="Additional information about the client..."><?php echo $client['additional_information']; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="edit_client" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
// Helper functions
function getStatusColor($status) {
    switch($status) {
        case 'Active': return 'success';
        case 'Pending': return 'warning';
        case 'Completed': return 'info';
        case 'Inactive': return 'danger';
        default: return 'secondary';
    }
}

function formatDate($date) {
    if(empty($date) || $date == '0000-00-00') return 'Not set';
    return date('M d, Y', strtotime($date));
}

function isRenewalDue($date) {
    if(empty($date)) return false;
    $renewalDate = strtotime($date);
    $today = strtotime('today');
    $warningDate = strtotime('+30 days', $today);
    return $renewalDate <= $warningDate;
}

function formatFileSize($bytes) {
    if($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}

function timeAgo($datetime) {
    $time = strtotime($datetime);
    $time_difference = time() - $time;
    
    if($time_difference < 1) { return 'less than 1 second ago'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );
    
    foreach($condition as $secs => $str) {
        $d = $time_difference / $secs;
        if($d >= 1) {
            $t = round($d);
            return $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
        }
    }
}
?>

<!-- Rename Folder Modal -->
<div class="modal fade" id="rename-folder-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content rounded-3">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Rename Folder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form action="php/rename_folder.php" method="POST">
                    <input type="hidden" name="folder_id" id="rename-folder-id">
                    <input type="hidden" name="client_id" value="<?= $id ?>">
                    <input type="hidden" name="current_folder_id" value="<?= $current_folder_id ?>">

                    <div class="mb-3">
                        <label for="new-folder-name" class="form-label">
                            New Folder Name
                        </label>
                        <input
                            type="text"
                            id="new-folder-name"
                            name="new_name"
                            class="form-control"
                            required
                        >
                    </div>

                    <!-- Modal Footer -->
                    <div class="d-flex justify-content-end gap-2">
                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Rename
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- JavaScript to handle modal data -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const renameButtons = document.querySelectorAll('.rename-folder-btn');
    const renameModal = document.getElementById('rename-folder-modal');
    const folderIdInput = document.getElementById('rename-folder-id');
    const folderNameInput = document.getElementById('new-folder-name');
    
    renameButtons.forEach(button => {
        button.addEventListener('click', function() {
            const folderId = this.getAttribute('data-folder-id');
            const folderName = this.getAttribute('data-folder-name');
            
            folderIdInput.value = folderId;
            folderNameInput.value = folderName;
            folderNameInput.focus();
        });
    });
});
</script>

<script>
    // Files Bulk Actions
document.addEventListener('DOMContentLoaded', function() {
    // Files bulk actions
    const filesBulkAction = document.getElementById('files-bulk-action');
    const applyFilesBulkAction = document.getElementById('apply-files-bulk-action');
    const filesSelectedCount = document.getElementById('files-selected-count');
    const fileFolderCheckboxes = document.querySelectorAll('.file-folder-checkbox');
    const bulkFilesForm = document.getElementById('bulk-files-form');
    
    // Update selected count when checkboxes change
    fileFolderCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateFilesSelectedCount);
    });
    
    function updateFilesSelectedCount() {
        const count = document.querySelectorAll('.file-folder-checkbox:checked').length;
        filesSelectedCount.textContent = count;
    }
    
    // Apply bulk action
    applyFilesBulkAction.addEventListener('click', function() {
        const selectedCount = document.querySelectorAll('.file-folder-checkbox:checked').length;
        
        if (selectedCount === 0) {
            alert('Please select at least one file or folder');
            return;
        }
        
        const action = filesBulkAction.value;
        
        if (!action) {
            alert('Please select an action');
            return;
        }
        
        if (action === 'delete') {
            if (confirm(`Are you sure you want to delete ${selectedCount} selected item(s)? This action cannot be undone.`)) {
                bulkFilesForm.submit();
            }
        }
    });
    
    // Select all functionality for files/folders
    const selectAllFiles = document.createElement('button');
    selectAllFiles.textContent = 'Select All';
    selectAllFiles.className = 'btn bg-gray-200 text-gray-700 text-sm ml-2';
    selectAllFiles.type = 'button';
    selectAllFiles.addEventListener('click', function() {
        const allChecked = document.querySelectorAll('.file-folder-checkbox:checked').length === fileFolderCheckboxes.length;
        fileFolderCheckboxes.forEach(checkbox => {
            checkbox.checked = !allChecked;
        });
        updateFilesSelectedCount();
    });
    
    document.querySelector('#files-bulk-action').parentNode.appendChild(selectAllFiles);
});
</script>



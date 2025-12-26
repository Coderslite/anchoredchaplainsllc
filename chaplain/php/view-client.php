<?php include "includes/header.php";

// Get client ID from URL
$client_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($client_id == 0) {
    echo "<script>alert('Invalid client ID'); window.location='clients.php';</script>";
    exit();
}


// Fetch client information
$client_query = mysqli_query($con, "SELECT * FROM clients WHERE id = $client_id");
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
                                    </div>
                                    
                                    <h6 class="mb-3 border-bottom pb-2">Program Details</h6>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <p class="text-muted mb-1">Program Applied</p>
                                            <p class="fw-medium mb-0"><?php echo $client['program_applied']; ?></p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-muted mb-1">Assigned Chaplain</p>
                                            <p class="fw-medium mb-0"><?php echo $client['assigned_chaplain']; ?></p>
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
                    <!-- File Manager Header -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">File Manager</h4>
                                <p class="text-muted mb-0">Organize and manage client documents</p>
                            </div>
                            <div>
                                <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#createFolderModal">
                                    <svg width="16" height="16" class="me-1">
                                        <use href="assets/svg/icon-sprite.svg#folder-plus"></use>
                                    </svg>
                                    New Folder
                                </button>
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadFileModal">
                                    <svg width="16" height="16" class="me-1">
                                        <use href="assets/svg/icon-sprite.svg#upload"></use>
                                    </svg>
                                    Upload File
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Folders Section -->
                    <?php include "components/client-files.php";?>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>

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
                            <label class="form-label">Program Applied</label>
                            <select class="form-select" name="program_applied">
                                <option value="">Select Program</option>
                                <option value="Spiritual Counseling" <?php echo $client['program_applied'] == 'Spiritual Counseling' ? 'selected' : ''; ?>>Spiritual Counseling</option>
                                <option value="Marriage Counseling" <?php echo $client['program_applied'] == 'Marriage Counseling' ? 'selected' : ''; ?>>Marriage Counseling</option>
                                <option value="Grief Support" <?php echo $client['program_applied'] == 'Grief Support' ? 'selected' : ''; ?>>Grief Support</option>
                                <option value="Addiction Recovery" <?php echo $client['program_applied'] == 'Addiction Recovery' ? 'selected' : ''; ?>>Addiction Recovery</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Assigned Chaplain</label>
                            <select class="form-select" name="assigned_chaplain">
                                <option value="">Select Chaplain</option>
                                <?php while($chaplain = mysqli_fetch_assoc($chaplains_query)): ?>
                                <option value="<?php echo $chaplain['name']; ?>" <?php echo $client['assigned_chaplain'] == $chaplain['name'] ? 'selected' : ''; ?>>
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

<!-- Create Folder Modal -->
<div class="modal fade" id="createFolderModal" tabindex="-1" aria-labelledby="createFolderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createFolderModalLabel">Create New Folder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="php/create_folder.php">
                <input type="hidden" value="<?php echo $client_id;?>" name="client_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Folder Name *</label>
                        <input type="text" class="form-control" name="folder_name" placeholder="Enter folder name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description (Optional)</label>
                        <textarea class="form-control" name="description" rows="2" placeholder="Brief description of folder contents"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="create_folder" class="btn btn-primary">Create Folder</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Upload File Modal -->
<div class="modal fade" id="uploadFileModal" tabindex="-1" aria-labelledby="uploadFileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadFileModalLabel">Upload Files</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="php/upload_file.php" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Folder *</label>
                        <select class="form-select" name="folder_id" required>
                            <option value="">Select Folder</option>
                            <?php 
                            // Reset folders pointer
                            mysqli_data_seek($folders_query, 0);
                            while($folder = mysqli_fetch_assoc($folders_query)): 
                            ?>
                            <option value="<?php echo $folder['id']; ?>"><?php echo $folder['folder_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Select Files *</label>
                        <div class="file-upload-area border rounded p-5 text-center">
                            <svg width="48" height="48" class="text-muted mb-3">
                                <use href="assets/svg/icon-sprite.svg#upload-cloud"></use>
                            </svg>
                            <h6 class="mb-2">Drop files here or click to upload</h6>
                            <p class="text-muted small mb-3">Maximum file size: 50MB</p>
                            <input type="file" class="form-control" name="files[]" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.txt" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">File Description (Optional)</label>
                        <textarea class="form-control" name="file_description" rows="2" placeholder="Add description for these files"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="upload_files" class="btn btn-primary">Upload Files</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Your existing CSS styles */
</style>

<?php include "includes/footer.php"; ?>

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
<div id="rename-folder-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:w-1/2 md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="rounded-2xl bg-white dark:bg-neutral-700 md:w-1/2 w-full p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Rename Folder</h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="rename-folder-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        
        <form action="php/rename_folder.php" method="POST">
            <input type="hidden" name="folder_id" id="rename-folder-id">
            <input type="hidden" name="client_id" value="<?= $id ?>">
            <input type="hidden" name="current_folder_id" value="<?= $current_folder_id ?>">
            
            <div class="mb-4">
                <label for="new-folder-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">New Folder Name</label>
                <input type="text" id="new-folder-name" name="new_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button type="button" data-modal-hide="rename-folder-modal" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                    Cancel
                </button>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Rename
                </button>
            </div>
        </form>
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

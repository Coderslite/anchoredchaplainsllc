<div class="container-fluid">

<?php
require_once 'php/client_folders.php';

$current_folder_id = isset($_GET['folder_id']) ? $_GET['folder_id'] : null;
$folders = get_client_folders($id, $current_folder_id);
$files = get_client_files($id, $current_folder_id);
$path = $current_folder_id ? get_client_folder_path($current_folder_id) : [];
?>

<!-- Bulk Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex gap-2">
        <select id="files-bulk-action" class="form-select form-select-sm w-auto">
            <option value="">Bulk Actions</option>
            <option value="delete">Delete Selected</option>
        </select>
        <button id="apply-files-bulk-action" class="btn btn-primary btn-sm">
            Apply
        </button>
    </div>

    <small class="text-muted">
        <span id="files-selected-count">0</span> items selected
    </small>
</div>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="view-client.php?id=<?= $id ?>">Root</a>
        </li>
        <?php foreach ($path as $folder): ?>
            <li class="breadcrumb-item">
                <a href="view-client.php?id=<?= $id ?>&folder_id=<?= $folder['id'] ?>">
                    <?= htmlspecialchars($folder['name']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ol>
</nav>

<!-- Create Folder -->
<div class="card mb-4">
    <div class="card-body">
        <form method="POST" action="php/create_folder.php" class="d-flex">
            <input type="hidden" name="client_id" value="<?= $id ?>">
            <input type="hidden" name="parent_id" value="<?= $current_folder_id ?>">
            <input type="text" name="folder_name" class="form-control rounded-0 rounded-start" placeholder="New folder name" required>
            <button type="submit" class="btn btn-primary rounded-0 rounded-end">
                Create Folder
            </button>
        </form>
    </div>
</div>

<!-- Upload File -->
<div class="card mb-4">
    <div class="card-body">
        <form method="POST" action="php/upload_file.php" enctype="multipart/form-data" class="d-flex">
            <input type="hidden" name="client_id" value="<?= $id ?>">
            <input type="hidden" name="folder_id" value="<?= $current_folder_id ?>">
            <input type="file" name="file_upload" class="form-control rounded-0 rounded-start" required>
            <button type="submit" class="btn btn-success rounded-0 rounded-end">
                Upload File
            </button>
        </form>
    </div>
</div>

<!-- Files & Folders -->
<form id="bulk-files-form" method="POST" action="php/bulk_delete_files.php">
    <input type="hidden" name="client_id" value="<?= $id ?>">
    <input type="hidden" name="folder_id" value="<?= $current_folder_id ?>">
    <input type="hidden" name="tab" value="files">

    <div class="row g-4">

        <!-- Folders -->
        <?php foreach ($folders as $folder): ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card text-center text-white bg-primary position-relative h-100">

                    <div class="position-absolute top-0 start-0 p-2">
                        <input type="checkbox" name="folder_ids[]" value="<?= $folder['id'] ?>" class="form-check-input file-folder-checkbox">
                    </div>

                    <div class="card-body">
                        <a href="view-client.php?id=<?= $id ?>&folder_id=<?= $folder['id'] ?>" class="text-white text-decoration-none">
                            <img src="../assets/images/folder2.png" class="mb-2" width="48">
                            <p class="mb-0 text-primary"><?= htmlspecialchars($folder['name']) ?></p>
                        </a>
                    </div>

                    <div class="card-footer bg-transparent border-0">
                        <button
                            type="button"
                            class="btn btn-success btn-sm rename-folder-btn"
                            data-folder-id="<?= $folder['id'] ?>"
                            data-folder-name="<?= htmlspecialchars($folder['name']) ?>"
                            data-bs-toggle="modal"
                            data-bs-target="#rename-folder-modal">
                           Rename
                        </button>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>

        <!-- Files -->
        <?php foreach ($files as $file): ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card text-center position-relative h-100">

                    <div class="position-absolute top-0 start-0 p-2">
                        <input type="checkbox" name="file_ids[]" value="<?= $file['id'] ?>" class="form-check-input file-folder-checkbox">
                    </div>

                    <div class="card-body">
                        <img src="../assets/images/file.jpg" class="mb-2" width="48">
                        <p class="fw-semibold text-truncate"><?= htmlspecialchars($file['name']) ?></p>
                        <small class="text-muted"><?= round($file['size'] / 1024, 1) ?> KB</small>
                    </div>

                    <div class="card-footer bg-white border-0">
                        <a href="<?= $file['file_path'] ?>" download class="text-primary small">
                            Download
                        </a>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>

    </div>
</form>

</div>

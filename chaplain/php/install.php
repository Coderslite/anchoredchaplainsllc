<?php
require_once 'db_config.php';

$sql = "
-- Create clients table
CREATE TABLE IF NOT EXISTS clients (
    id INT PRIMARY KEY AUTO_INCREMENT,
    client_id VARCHAR(50) UNIQUE NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    avatar VARCHAR(255) DEFAULT 'default.jpg',
    program_applied VARCHAR(100),
    assigned_chaplain VARCHAR(100),
    applied_date DATE,
    approved_date DATE,
    renewed_date DATE,
    status ENUM('Active', 'Pending', 'Completed', 'Inactive') DEFAULT 'Pending',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_program (program_applied)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create client_folders table
CREATE TABLE IF NOT EXISTS client_folders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    client_id INT NOT NULL,
    folder_name VARCHAR(100) NOT NULL,
    description TEXT,
    access_level ENUM('Private', 'Team', 'Public') DEFAULT 'Private',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
    INDEX idx_client (client_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create client_files table
CREATE TABLE IF NOT EXISTS client_files (
    id INT PRIMARY KEY AUTO_INCREMENT,
    client_id INT NOT NULL,
    folder_id INT,
    file_name VARCHAR(255) NOT NULL,
    original_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_type VARCHAR(50),
    file_size INT,
    description TEXT,
    uploaded_by INT,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
    FOREIGN KEY (folder_id) REFERENCES client_folders(id) ON DELETE SET NULL,
    INDEX idx_client (client_id),
    INDEX idx_folder (folder_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create chaplains table
CREATE TABLE IF NOT EXISTS chaplains (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    status ENUM('Active', 'Inactive') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create users table for admin
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('Admin', 'Chaplain') DEFAULT 'Chaplain',
    status ENUM('Active', 'Inactive') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin user (password: admin123)
INSERT INTO users (username, email, password, role) VALUES 
('admin', 'admin@example.com', '$2y$10$YourHashedPasswordHere', 'Admin')
ON DUPLICATE KEY UPDATE email = VALUES(email);

-- Insert sample chaplains
INSERT INTO chaplains (name, email, phone) VALUES 
('Rev. Sarah Johnson', 'sarah@example.com', '+1234567890'),
('Rev. Michael Brown', 'michael@example.com', '+1234567891'),
('Rev. Emily Davis', 'emily@example.com', '+1234567892')
ON DUPLICATE KEY UPDATE phone = VALUES(phone);
";

// Execute SQL
if(mysqli_multi_query($con, $sql)) {
    echo "Database tables created successfully!<br>";
    
    // Check for errors
    while(mysqli_next_result($con)) {
        if($error = mysqli_error($con)) {
            echo "Error: $error<br>";
        }
    }
} else {
    echo "Error creating tables: " . mysqli_error($con);
}

mysqli_close($con);
?>
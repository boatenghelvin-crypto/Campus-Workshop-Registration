-- Campus Connect: run this SQL in phpMyAdmin after creating/selecting your hosting database.
-- Do not run CREATE DATABASE on managed hosts (e.g., InfinityFree).
CREATE TABLE IF NOT EXISTS registrations (
    registration_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(190) NOT NULL,
    workshop_code VARCHAR(40) NOT NULL,
    attendance_mode ENUM('Online', 'In person') NOT NULL,
    notes VARCHAR(500) DEFAULT NULL,
    submitted_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (registration_id),
    INDEX idx_registrations_workshop (workshop_code),
    INDEX idx_registrations_submitted (submitted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

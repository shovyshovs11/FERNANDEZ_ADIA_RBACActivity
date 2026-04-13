-- rbac_migration.sql

-- 1. Create the `roles` table
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT 'slug (e.g., admin, teacher, student)',
  `label` varchar(100) NOT NULL COMMENT 'Human readable label (e.g., Administrator)',
  `description` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 2. Insert the 4 roles
INSERT INTO `roles` (`name`, `label`, `description`) VALUES
('admin', 'Administrator', 'Has full access to the system, including role management.'),
('teacher', 'Teacher', 'Can manage students and view dashboards.'),
('student', 'Student', 'Limited access, can only view student dashboard and profile.'),
('coordinator', 'Coordinator', 'Challenge role - coordinates specific activities.');

-- 3. Add `role_id` foreign key column to `users` table
-- Ensure that `role_id` is an unsigned int since `roles.id` is unsigned
ALTER TABLE `users`
  ADD COLUMN `role_id` int(11) UNSIGNED DEFAULT NULL AFTER `id`;

-- Add foreign key constraint
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

-- 4. Insert 4 demo user accounts
-- The passwords are all 'Password1', hashed using bcrypt (cost=10, generated via PHP password_hash)
-- PWD Hash for 'Password1': $2y$10$7c/1R6R4m.kOMR0o2iEwF.wN7Z4.sJ5KqE5K1kI2E0H4Fj.B8Vn8m
INSERT INTO `users` (`role_id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
((SELECT `id` FROM `roles` WHERE `name`='admin'), 'Admin User', 'admin@school.edu', '$2y$10$7c/1R6R4m.kOMR0o2iEwF.wN7Z4.sJ5KqE5K1kI2E0H4Fj.B8Vn8m', NOW(), NOW()),
((SELECT `id` FROM `roles` WHERE `name`='teacher'), 'Teacher User', 'teacher@school.edu', '$2y$10$7c/1R6R4m.kOMR0o2iEwF.wN7Z4.sJ5KqE5K1kI2E0H4Fj.B8Vn8m', NOW(), NOW()),
((SELECT `id` FROM `roles` WHERE `name`='student'), 'Student User', 'student@school.edu', '$2y$10$7c/1R6R4m.kOMR0o2iEwF.wN7Z4.sJ5KqE5K1kI2E0H4Fj.B8Vn8m', NOW(), NOW()),
((SELECT `id` FROM `roles` WHERE `name`='coordinator'), 'Coordinator User', 'coord@school.edu', '$2y$10$7c/1R6R4m.kOMR0o2iEwF.wN7Z4.sJ5KqE5K1kI2E0H4Fj.B8Vn8m', NOW(), NOW());

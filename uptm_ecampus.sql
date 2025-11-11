-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2025 at 06:31 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uptm_ecampus`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `user_id`, `subject_id`, `created_at`, `updated_at`) VALUES
(1, 'helo', 'helo', 2, NULL, '2025-11-10 06:34:10', '2025-11-10 06:34:10'),
(2, 'Welcome to Semester 1 2024', 'Welcome all students to the new semester! Please check your schedules and course materials.', 1, NULL, '2025-11-10 09:48:29', '2025-11-10 09:48:29'),
(3, 'Web Development Class Cancelled', 'Web Development class on Friday is cancelled due to public holiday. Next class will be on Monday.', 2, 1, '2025-11-10 09:48:29', '2025-11-10 09:48:29'),
(4, 'Database Assignment Deadline', 'Reminder: Database assignment submission deadline is this Friday 5:00 PM.', 2, 2, '2025-11-10 09:48:29', '2025-11-10 09:48:29'),
(5, 'Cyber Security Lab Session', 'There will be a special lab session for Cyber Security this Wednesday at Lab 3.', 2, 3, '2025-11-10 09:48:29', '2025-11-10 09:48:29');

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `subject_id` int(11) NOT NULL,
  `lecturer_id` int(11) NOT NULL,
  `due_date` datetime NOT NULL,
  `max_marks` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `title`, `description`, `subject_id`, `lecturer_id`, `due_date`, `max_marks`, `created_at`, `updated_at`) VALUES
(1, 'assg 2', 'complete it', 1, 2, '2025-12-01 13:05:00', 100, '2025-11-05 21:05:07', '2025-11-10 12:13:40');

-- --------------------------------------------------------

--
-- Table structure for table `assignment_submissions`
--

CREATE TABLE `assignment_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assignment_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `comments` text DEFAULT NULL,
  `marks` decimal(5,2) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `graded_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `status` enum('present','absent','late','excused') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `student_id`, `subject_id`, `date`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 1, '2025-11-05', 'present', '2025-11-10 09:40:54', '2025-11-10 09:40:54'),
(2, 4, 2, '2025-11-06', 'present', '2025-11-10 09:40:54', '2025-11-10 09:40:54'),
(3, 4, 3, '2025-11-07', 'late', '2025-11-10 09:40:54', '2025-11-10 09:40:54'),
(4, 4, 1, '2025-11-08', 'absent', '2025-11-10 09:40:54', '2025-11-10 09:40:54'),
(5, 4, 2, '2025-11-09', 'present', '2025-11-10 09:40:54', '2025-11-10 09:40:54'),
(6, 4, 1, '2025-11-05', 'present', '2025-11-10 09:48:29', '2025-11-10 09:48:29'),
(7, 4, 2, '2025-11-06', 'present', '2025-11-10 09:48:29', '2025-11-10 09:48:29'),
(8, 4, 3, '2025-11-07', 'late', '2025-11-10 09:48:29', '2025-11-10 09:48:29'),
(9, 4, 1, '2025-11-08', 'absent', '2025-11-10 09:48:29', '2025-11-10 09:48:29'),
(10, 4, 2, '2025-11-09', 'present', '2025-11-10 09:48:29', '2025-11-10 09:48:29'),
(11, 4, 1, '2025-11-05', 'present', '2025-11-10 09:52:17', '2025-11-10 09:52:17'),
(12, 4, 2, '2025-11-06', 'present', '2025-11-10 09:52:17', '2025-11-10 09:52:17'),
(13, 4, 3, '2025-11-07', 'late', '2025-11-10 09:52:17', '2025-11-10 09:52:17'),
(14, 4, 1, '2025-11-08', 'absent', '2025-11-10 09:52:17', '2025-11-10 09:52:17'),
(15, 4, 2, '2025-11-09', 'present', '2025-11-10 09:52:17', '2025-11-10 09:52:17'),
(16, 4, 1, '2025-11-05', 'present', '2025-11-10 09:53:31', '2025-11-10 09:53:31'),
(17, 4, 2, '2025-11-06', 'present', '2025-11-10 09:53:31', '2025-11-10 09:53:31'),
(18, 4, 3, '2025-11-07', 'late', '2025-11-10 09:53:31', '2025-11-10 09:53:31'),
(19, 4, 1, '2025-11-08', 'absent', '2025-11-10 09:53:31', '2025-11-10 09:53:31'),
(20, 4, 2, '2025-11-09', 'present', '2025-11-10 09:53:31', '2025-11-10 09:53:31');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `title`, `type`, `file_path`, `subject_id`, `created_at`, `updated_at`) VALUES
(1, 'Web Development Syllabus', 'syllabus', '/documents/syllabus.pdf', 1, '2025-11-10 09:40:54', '2025-11-10 09:40:54'),
(2, 'Database Notes Chapter 1', 'notes', '/documents/db_notes.pdf', 2, '2025-11-10 09:40:54', '2025-11-10 09:40:54'),
(3, 'Cyber Security Lab Manual', 'lab_manual', '/documents/lab_manual.pdf', 3, '2025-11-10 09:40:54', '2025-11-10 09:40:54'),
(4, 'Academic Calendar 2024', 'resources', '/documents/calendar.pdf', 1, '2025-11-10 09:48:29', '2025-11-10 09:48:29');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `assignment_name` varchar(255) NOT NULL,
  `marks` decimal(5,2) NOT NULL,
  `max_marks` decimal(5,2) NOT NULL DEFAULT 100.00,
  `grade` varchar(255) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `assignment_name`, `marks`, `max_marks`, `grade`, `comments`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 'HTML/CSS Project', 85.00, 100.00, 'A', NULL, '2025-11-10 09:40:54', '2025-11-10 09:40:54'),
(2, 4, 2, 'SQL Quiz', 72.00, 100.00, 'B', NULL, '2025-11-10 09:40:54', '2025-11-10 09:40:54'),
(3, 4, 3, 'Security Report', 90.00, 100.00, 'A', NULL, '2025-11-10 09:40:54', '2025-11-10 09:40:54'),
(4, 4, 1, 'JavaScript Assignment', 68.00, 100.00, 'C', NULL, '2025-11-10 09:40:54', '2025-11-10 09:40:54');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_10_13_173030_create_simple_ecampus_tables', 2),
(6, '2025_11_03_180035_create_announcements_table', 3),
(7, '2025_11_03_190445_create_assignments_table', 3),
(8, '2025_11_10_171940_create_subjects_table', 3),
(9, '2025_11_10_053111_add_role_to_users_table', 3),
(10, '2025_11_06_045956_add_is_published_to_assignments_table', 3),
(11, '2025_11_10_171445_create_grades_table', 4),
(12, '2025_11_10_171653_create_attendances_table', 4),
(13, '2025_11_10_171759_create_documents_table', 4),
(14, '2025_11_10_192516_create_assignment_submissions_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `lecturer_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `code`, `name`, `description`, `lecturer_id`, `created_at`, `updated_at`) VALUES
(1, 'WEB101', 'Web Development', NULL, 2, '2025-11-10 09:37:54', '2025-11-10 09:37:54'),
(2, 'DBMS202', 'Database Systems', NULL, 2, '2025-11-10 09:37:54', '2025-11-10 09:37:54'),
(3, 'CYBER301', 'Cyber Security', NULL, 2, '2025-11-10 09:37:54', '2025-11-10 09:37:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `role` enum('student','lecturer','admin') NOT NULL DEFAULT 'student',
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `student_id`, `role`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'System Administrator', 'admin@uptm.edu.my', NULL, 'admin', '$2y$10$e8p6R05.oGR.QBZZnNWiUe8mWaddCRDqUYwp7mS9aMOSbXFEInZju', NULL, '2025-11-09 21:50:53', '2025-11-09 21:50:53'),
(2, 'Dr. Lecturer', 'lecturer@uptm.edu.my', NULL, 'lecturer', '$2y$10$akmJyBkbt0/bxQT6UXrRce9ViXcWgWa/aoezwRle7vIgl43at0.xK', NULL, '2025-11-09 21:50:54', '2025-11-09 21:50:54'),
(3, 'Nur Amymelinda', 'am2311015254@uptm.edu.my', 'AM2311015254', 'student', '$2y$10$icCkFYreIs/MbchjyzgdZe7gA3Cw5HU7/a21j0hVPAo3HcOE4DlD6', NULL, '2025-11-09 21:50:54', '2025-11-09 21:50:54'),
(4, 'Ali Student', 'student@uptm.edu.my', 'S12345', 'student', '$2y$10$e.qDhfqPL6w79C0m/bcsyeERtXK95cbnGYzCq10mYztciD1PS27SO', NULL, '2025-11-10 09:37:54', '2025-11-10 09:37:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `assignment_submissions_assignment_id_student_id_unique` (`assignment_id`,`student_id`),
  ADD KEY `assignment_submissions_student_id_foreign` (`student_id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_student_id_foreign` (`student_id`),
  ADD KEY `attendances_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grades_student_id_foreign` (`student_id`),
  ADD KEY `grades_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  ADD CONSTRAINT `assignment_submissions_assignment_id_foreign` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assignment_submissions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `attendances_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `grades_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

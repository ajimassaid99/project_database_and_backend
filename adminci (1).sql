-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2024 at 06:13 AM
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
-- Database: `adminci`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `kode_barang` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `nama_barang`, `kode_barang`, `created_at`, `updated_at`) VALUES
(2, 'Baut1', 'B1', '2024-08-23 21:36:49', '2024-08-23 21:41:28'),
(3, 'Mur', 'M1', '2024-09-10 11:35:46', '2024-09-10 11:35:46');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2021-05-20-124016', 'App\\Database\\Migrations\\Users', 'default', 'App', 1724420748, 1),
(2, '2021-05-20-124435', 'App\\Database\\Migrations\\Session', 'default', 'App', 1724420748, 1),
(3, '2021-05-20-125608', 'App\\Database\\Migrations\\UserRole', 'default', 'App', 1724420748, 1),
(4, '2021-05-20-125818', 'App\\Database\\Migrations\\UserAccess', 'default', 'App', 1724420748, 1),
(5, '2021-05-20-130307', 'App\\Database\\Migrations\\UserMenu', 'default', 'App', 1724420748, 1),
(6, '2021-05-20-130307', 'App\\Database\\Migrations\\UserSubmenu', 'default', 'App', 1724420748, 1),
(7, '2021-05-24-100652', 'App\\Database\\Migrations\\User', 'default', 'App', 1724420748, 1),
(8, '2021-05-25-102709', 'App\\Database\\Migrations\\UserMenuCategory', 'default', 'App', 1724420748, 1);

-- --------------------------------------------------------

--
-- Table structure for table `produksi`
--

CREATE TABLE `produksi` (
  `id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `jumlah_produksi` int(11) DEFAULT NULL,
  `barcode` varchar(255) NOT NULL,
  `tanggal_produksi` date NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('start','onProgres','finis') NOT NULL DEFAULT 'start'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `produksi`
--

INSERT INTO `produksi` (`id`, `barang_id`, `shift_id`, `jumlah_produksi`, `barcode`, `tanggal_produksi`, `created_at`, `updated_at`, `status`) VALUES
(2, 2, 1, NULL, '6810213653', '2024-08-28', '2024-08-26 17:08:08', '2024-08-26 17:08:08', 'start'),
(3, 2, 1, NULL, '5727077641', '2024-08-28', '2024-08-26 17:11:17', '2024-08-26 17:11:17', 'start'),
(4, 2, 1, NULL, '1214837659', '2024-09-05', '2024-09-04 09:15:08', '2024-09-04 09:15:08', 'start'),
(5, 3, 1, NULL, '4808067796', '2024-09-10', '2024-09-10 12:43:19', '2024-09-10 12:43:19', 'start'),
(6, 2, 2, NULL, '4035007160', '2024-09-10', '2024-09-11 11:53:22', '2024-09-11 11:55:18', 'start'),
(7, 2, 1, NULL, '1004717386', '2024-09-10', '2024-09-11 12:55:38', '2024-09-11 12:58:31', 'start');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `produksi_id` int(11) NOT NULL,
  `jam_produksi` time NOT NULL,
  `jumlah_produksi` int(11) NOT NULL,
  `created_by` int(11) UNSIGNED NOT NULL,
  `report_data` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `produksi_id`, `jam_produksi`, `jumlah_produksi`, `created_by`, `report_data`, `created_at`) VALUES
(1, 2, '09:09:10', 5000, 1, 'input by scan barcode', '2024-09-03 21:09:16'),
(2, 2, '10:09:10', 9000, 1, 'input by scan barcode', '2024-09-03 10:09:16'),
(3, 2, '11:09:10', 16000, 1, 'input by scan barcode', '2024-09-03 11:09:16'),
(4, 2, '12:09:10', 20000, 1, 'input by scan barcode', '2024-09-03 12:09:16'),
(5, 2, '13:09:10', 23000, 1, 'input by scan barcode', '2024-09-03 13:09:16'),
(6, 2, '14:09:10', 27000, 1, 'input by scan barcode', '2024-09-03 14:09:16'),
(7, 2, '15:09:10', 30000, 1, 'input by scan barcode', '2024-09-03 15:09:16'),
(8, 2, '16:09:10', 35000, 1, 'input by scan barcode', '2024-09-03 16:09:16'),
(9, 2, '09:15:30', 50000, 1, 'input by scan barcode', '2024-09-03 21:15:37'),
(10, 5, '12:44:36', 5000, 1, '{\"note\":\"Laporan produksi telah dibuat\"}', '2024-09-10 00:44:42'),
(11, 5, '13:44:36', 8000, 1, '{\"note\":\"Laporan produksi telah dibuat\"}', '2024-09-10 00:44:42'),
(12, 6, '14:54:15', 5000, 1, '{\"note\":\"Laporan produksi telah dibuat\"}', '2024-09-10 23:54:21'),
(13, 7, '12:56:27', 5000, 1, '{\"note\":\"Laporan produksi telah dibuat\"}', '2024-09-11 00:56:36'),
(14, 2, '08:58:30', 7000, 1, '{\"note\":\"Laporan produksi telah dibuat\"}', '2024-09-11 08:58:38');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('ci_session:k5etvvrgkpgspkhe2n3rlgv7p6mnlp95', '::1', '2024-09-11 06:28:42', 0x5f5f63695f6c6173745f726567656e65726174657c693a313732363033353737343b5f63695f70726576696f75735f75726c7c733a33363a22687474703a2f2f6c6f63616c686f73743a383038302f696e6465782e7068702f686f6d65223b757365726e616d657c733a31343a22746573746572406d61696c2e696f223b726f6c657c733a313a2231223b69734c6f67676564496e7c623a313b),
('ci_session:71lluh2887k8cfcnphqqtafraij798aa', '::1', '2024-09-11 13:59:32', 0x5f5f63695f6c6173745f726567656e65726174657c693a313732363036323939323b5f63695f70726576696f75735f75726c7c733a33363a22687474703a2f2f6c6f63616c686f73743a383038302f696e6465782e7068702f686f6d65223b757365726e616d657c733a31343a22746573746572406d61696c2e696f223b726f6c657c733a313a2231223b69734c6f67676564496e7c623a313b),
('ci_session:4ro3plirk4f6obur4l9torbjnfueci6g', '::1', '2024-09-12 04:10:54', 0x5f5f63695f6c6173745f726567656e65726174657c693a313732363131343031383b5f63695f70726576696f75735f75726c7c733a33363a22687474703a2f2f6c6f63616c686f73743a383038302f696e6465782e7068702f686f6d65223b757365726e616d657c733a31343a22746573746572406d61696c2e696f223b726f6c657c733a313a2231223b69734c6f67676564496e7c623a313b);

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `id` int(11) NOT NULL,
  `shift_name` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `shifts`
--

INSERT INTO `shifts` (`id`, `shift_name`, `start_time`, `end_time`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'siang', '14:00:00', '22:00:00', '1', '2024-08-23 08:51:00', '2024-08-23 20:52:22'),
(2, 'pagi', '06:00:00', '14:00:00', '1', '2024-09-10 23:32:00', '2024-09-10 23:32:00'),
(3, 'malam', '22:00:00', '06:00:00', '1', '2024-09-10 23:33:00', '2024-09-11 12:48:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(5) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Developer Tester', 'tester@mail.io', '$2y$10$wJn0uZ7QXIOyIwdXHzwMXOE.TWFJ2/agVATf2DlbmXDRXQkNTnCwq', 1, '2024-08-23 08:45:59', '0000-00-00 00:00:00'),
(2, 'admin', 'rmass@gmail.com', '$2y$10$6HDKDzXgxkiIXB6h8V7QbOSbuddV2/DbD/7caDVns/Aisdmdg4zrK', 2, '2024-08-23 08:53:02', '0000-00-00 00:00:00'),
(3, 'Aji', 'amas@gmail.com', '$2y$10$fCL80zj0VDSAINqp.f8DbepWDDser7TQg0gzzl0YtsfC5HeoXz7Au', 3, '2024-08-28 02:49:17', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_access`
--

CREATE TABLE `user_access` (
  `id` int(11) UNSIGNED NOT NULL,
  `role_id` int(11) UNSIGNED NOT NULL,
  `menu_category_id` int(11) UNSIGNED NOT NULL,
  `menu_id` int(11) UNSIGNED NOT NULL,
  `submenu_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_access`
--

INSERT INTO `user_access` (`id`, `role_id`, `menu_category_id`, `menu_id`, `submenu_id`) VALUES
(1, 1, 1, 0, 0),
(2, 1, 0, 1, 0),
(3, 1, 2, 0, 0),
(4, 1, 0, 2, 0),
(5, 1, 3, 0, 0),
(6, 1, 0, 3, 0),
(7, 1, 0, 4, 0),
(8, 1, 0, 5, 0),
(9, 2, 1, 0, 0),
(10, 2, 0, 1, 0),
(11, 2, 0, 2, 0),
(12, 2, 0, 5, 0),
(13, 1, 0, 6, 0),
(14, 1, 0, 7, 0),
(15, 1, 0, 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) UNSIGNED NOT NULL,
  `menu_category` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon` text NOT NULL,
  `parent` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu_category`, `title`, `url`, `icon`, `parent`) VALUES
(1, 1, 'Dashboard', 'home', 'home', 0),
(2, 1, 'Users', 'users', 'user', 0),
(5, 1, 'Shift', 'shift', 'watch', 0),
(6, 1, 'Barang', 'barang', 'briefcase', 0),
(7, 1, 'Produksi', 'produksi', 'list', 0),
(8, 1, 'report operator', 'reportOperator', 'book', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu_category`
--

CREATE TABLE `user_menu_category` (
  `id` int(11) UNSIGNED NOT NULL,
  `menu_category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_menu_category`
--

INSERT INTO `user_menu_category` (`id`, `menu_category`) VALUES
(1, 'Common Page');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) UNSIGNED NOT NULL,
  `role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role_name`) VALUES
(1, 'Developer'),
(2, 'Admin'),
(3, 'Operator'),
(4, 'Manager');

-- --------------------------------------------------------

--
-- Table structure for table `user_submenu`
--

CREATE TABLE `user_submenu` (
  `id` int(11) UNSIGNED NOT NULL,
  `menu` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_barang` (`kode_barang`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produksi`
--
ALTER TABLE `produksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_id` (`barang_id`),
  ADD KEY `shift_id` (`shift_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produksi_id` (`produksi_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`timestamp`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access`
--
ALTER TABLE `user_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu_category`
--
ALTER TABLE `user_menu_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_submenu`
--
ALTER TABLE `user_submenu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `produksi`
--
ALTER TABLE `produksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_access`
--
ALTER TABLE `user_access`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_menu_category`
--
ALTER TABLE `user_menu_category`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_submenu`
--
ALTER TABLE `user_submenu`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `produksi`
--
ALTER TABLE `produksi`
  ADD CONSTRAINT `produksi_ibfk_1` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`),
  ADD CONSTRAINT `produksi_ibfk_2` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`produksi_id`) REFERENCES `produksi` (`id`),
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

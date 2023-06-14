-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2023 at 02:56 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `email_admin` varchar(100) NOT NULL,
  `password_admin` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uploaded_on` datetime NOT NULL,
  `status` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `nama_buku` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deskripsi` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  `penulis` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tanggal_terbit` date NOT NULL,
  `penerbit` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status_buku` tinyint(1) NOT NULL,
  `idKategoriBuku` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `file_name`, `uploaded_on`, `status`, `nama_buku`, `deskripsi`, `penulis`, `tanggal_terbit`, `penerbit`, `status_buku`, `idKategoriBuku`, `jumlah_peminjaman`) VALUES
(5, '492187.jpg', '2023-06-06 16:45:50', '1', 'Harry Potter 1', 'Harry dan Ron masuk ke platform 9 3/4', 'J K rowling', '2018-07-13', 'universal', 0, 6),
(6, '492187.jpg', '2023-06-06 19:17:14', '1', 'Harry Potter 3', 'waaw heri poter', 'J K rowling', '2023-05-31', 'universal', 0, 9),
(7, 'coverskripsi.png', '2023-06-14 11:31:58', '1', 'Panduan Mengerjakan Skripsi', 'Belajar banyak hal untuk mempersiapkan skripsi terbaikmu', 'Yayasan Pendidikan Islam', '2017-06-21', 'Gramedia', '1', '7', '7'),
(8, 'sejarah.jpg', '2020-04-08 16:34:36', '1', 'Atlas Sejarah Indonesia & Dunia', 'Untuk SD, SMP , SMA dan Umum', 'Kartika.D', '2023-07-12', 'Erlangga', '1', '7', '5'),
(9, 'bukuanak.jpg', '2018-06-03 16:36:34', '1', 'Juz Amma', 'Untuk anak-anak ', 'Bambang Hadisucipto', '2020-03-02', 'Keira', '0', '2', '7'),
(10, 'bukuyoga.jpg', '2019-12-04 16:38:38', '1', 'Yoga & Pilates', 'Belajar tahap dan langkah Yoga yang baik dan benar bersama dengan expert', 'Ririen Kartika ', '2019-03-01', 'DeepPublish', '1', '13', '4'),
(11, 'bukusaham.jpg', '2018-01-01 16:43:11', '1', 'Analisis Saham dan Fundamental', 'Belajar saham? jangan asal-asalan', 'Desmond Wira', '2022-08-03', 'BukuKita', '0', '7', '5')







-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'sejarah'),
(2, 'anak'),
(3, 'horror'),
(4, 'komedi'),
(5, 'thriller'),
(6, 'misteri'),
(7, 'edukasi'),
(8, 'biografi'),
(9, 'kamus'),
(10, 'komik'),
(11, 'novel'),
(12, 'skripsi');
(13, 'olahraga');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat`
--

CREATE TABLE `riwayat` (
  `id_pinjam` int(11) NOT NULL,
  `id_buku_pinjam` int(11) NOT NULL,
  `id_user_pinjam` int(11) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id_status` int(11) NOT NULL,
  `keterangan_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id_status`, `keterangan_status`) VALUES
(0, 'Tidak Tersedia'),
(1, 'Tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `email`, `nama_user`, `password`) VALUES
(1, 'user1@gmail.com', 'user1', '7a61fea8b048890a390c18746e04c5f1'),
(2, 'user1@gmail.com', 'user1', '7a61fea8b048890a390c18746e04c5f1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_buku` (`idKategoriBuku`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `riwayat`
--
ALTER TABLE `riwayat`
  ADD PRIMARY KEY (`id_pinjam`),
  ADD KEY `idPinjamUser` (`id_user_pinjam`),
  ADD KEY `idPinjamBuku` (`id_buku_pinjam`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id_status`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--

-- ADD kolom Jumlah_Peminjaman di tabel books 
-- 
ALTER TABLE `books`
ADD COLUMN `jumlah_peminjaman` INT NOT NULL DEFAULT 0 AFTER `idKategoriBuku`;

--

-- AUTO_INCREMENT for table `kategori`

--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `riwayat`
--
ALTER TABLE `riwayat`
  MODIFY `id_pinjam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `kategori_buku` FOREIGN KEY (`idKategoriBuku`) REFERENCES `kategori` (`id_kategori`);

--
-- Constraints for table `riwayat`
--
ALTER TABLE `riwayat`
  ADD CONSTRAINT `idPinjamBuku` FOREIGN KEY (`id_buku_pinjam`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `idPinjamUser` FOREIGN KEY (`id_user_pinjam`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

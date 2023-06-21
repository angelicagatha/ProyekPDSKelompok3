-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2023 at 10:57 AM
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
-- Database: `library`
--

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
  `idKategoriBuku` int(11) NOT NULL,
  `jumlah_peminjaman` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `file_name`, `uploaded_on`, `status`, `nama_buku`, `deskripsi`, `penulis`, `tanggal_terbit`, `penerbit`, `status_buku`, `idKategoriBuku`, `jumlah_peminjaman`) VALUES
(7, 'coverskripsi.png', '2023-06-14 11:31:58', '1', 'Panduan Mengerjakan Skripsi', 'Belajar banyak hal untuk mempersiapkan skripsi terbaikmu', 'Yayasan Pendidikan Islam', '2017-06-21', 'Gramedia', 0, 12, 1),
(8, 'sejarah.jpg', '2020-04-08 16:34:36', '1', 'Atlas Sejarah Indonesia & Dunia', 'Untuk SD, SMP , SMA dan Umum', 'Kartika.D', '2023-07-12', 'Erlangga', 0, 7, 1),
(9, 'bukuanak.jpg', '2018-06-03 16:36:34', '1', 'Juz Amma', 'Untuk anak-anak belajar', 'Bambang Hadisucipto', '2020-03-02', 'Keira', 0, 7, 4),
(10, 'bukuyoga.jpg', '2019-12-04 16:38:38', '1', 'Yoga & Pilates', 'Belajar tahap dan langkah Yoga yang baik dan benar bersama dengan expert', 'Ririen Kartika ', '2019-03-01', 'DeepPublish', 1, 13, 1),
(11, 'bukusaham.jpg', '2018-01-01 16:43:11', '1', 'Analisis Saham dan Fundamental', 'Belajar saham? jangan asal-asalan', 'Desmond Wira', '2022-08-03', 'BukuKita', 1, 7, 0),
(12, 'dongeng.jpeg', '2023-06-17 18:09:30', '1', 'Dongeng Anak Terlengkap', 'Ini adalah buku dongeng seri hewan terlengkap', 'Kak Thifa', '2020-06-03', 'PT XYZ', 1, 2, 3),
(16, 'hungergames1.jpg', '2023-06-20 19:38:12', '1', 'The Hunger Games', 'In the ruins of a place once known as North America lies the nation of Panem, a shining Capitol surrounded by twelve outlying districts. The Capitol is harsh and cruel and keeps the districts in line by forcing them all to send one boy and one girl between the ages of twelve and eighteen to participate in the annual Hunger Games, a fight to the death on live TV.\r\n\r\nSixteen-year-old Katniss Everdeen, who lives alone with her mother and younger sister, regards it as a death sentence when she steps forward to take her sister\'s place in the Games. But Katniss has been close to dead before—and survival, for her, is second nature. Without really meaning to, she becomes a contender. But if she is to win, she will have to start making choices that weight survival against humanity and life against love.', 'Suzanne Collins', '2008-06-10', 'Scholastic Press', 0, 0, 0),
(17, 'daisy-jones-and-the-six-1.jpg', '2023-06-20 19:38:12', '1', 'Daisy Jones and The Six', 'Buku mengenai band yang beranggotakan Daisy dan keenam teman - temannya', 'Taylor Jenkins Reid', '2019-05-06', 'Penguin Books', 0, 11, 0),
(18, 'Harry_Potter_and_the_Deathly_Hallows.jpg', '2023-06-21 00:57:06', '1', 'Harry Potter and the Deathly Hallows', 'At Malfoy Manor, Snape tells Voldemort the date that Harry’s friends are planning to move him from the house on Privet Drive to a new safe location, so that Voldemort can capture Harry en route.\r\n\r\nAs Harry packs to leave Privet Drive, he reads two obituaries for Dumbledore, both of which make him think that he didn’t know Dumbledore as well as he should have. Downstairs, he bids good-bye to the Dursleys for the final time, as the threat of Voldemort forces them to go into hiding themselves.\r\n\r\nThe Order of the Phoenix, led by Alastor “Mad-Eye” Moody, arrives to take Harry to his new home at the Weasleys’ house, the Burrow. Six of Harry’s friends take Polyjuice Potion to disguise themselves as Harry and act as decoys, and they all fly off in different directions. The Death Eaters, alerted to their departure by Snape, attack Harry and his friends. Voldemort chases Harry down, but Harry’s wand fends Voldemort off, seemingly without Harry’s help.', 'J K rowling', '2007-07-21', 'Bloomsbury', 1, 11, 0),
(19, 'hungergames1.jpg', '2023-06-21 01:08:45', '1', 'Hunger Games 2', 'Katnis and Peetah', 'Suzanne Collins', '2010-06-08', 'Bloomsbury', 1, 6, 0),
(20, 'Harry_Potter_and_the_Half-Blood_Prince_cover.png', '2023-06-21 01:23:06', '1', 'Harry Potter and The Half Blood prince', 'Harry , Ron and Hemione finally meet Voldemorde', 'J K rowling', '2009-05-04', 'Bloomsbury', 1, 11, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_buku` (`idKategoriBuku`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

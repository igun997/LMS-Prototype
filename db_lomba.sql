-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 26 Feb 2017 pada 11.56
-- Versi Server: 10.1.13-MariaDB
-- PHP Version: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_lomba`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_reset`
--

CREATE TABLE `log_reset` (
  `id_log` int(11) NOT NULL,
  `log_id_reset` int(11) NOT NULL,
  `log_id_siswa` int(11) NOT NULL,
  `log_id_jawaban` int(11) NOT NULL,
  `log_id_guru` int(11) NOT NULL,
  `log_nama_siswa` varchar(20) NOT NULL,
  `log_nama_guru` varchar(20) NOT NULL,
  `log_nama_ujian` varchar(20) NOT NULL,
  `tgl_log` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `p_sms`
--

CREATE TABLE `p_sms` (
  `user_api` varchar(50) DEFAULT NULL,
  `pass_api` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `p_sms`
--

INSERT INTO `p_sms` (`user_api`, `pass_api`) VALUES
('e12u4y', 'indra290997');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sistem_bank_soal`
--

CREATE TABLE `sistem_bank_soal` (
  `id_bank_soal` int(11) NOT NULL,
  `soal` text NOT NULL,
  `pilihan` text NOT NULL,
  `jawaban` varchar(11) NOT NULL,
  `guru_id` int(11) NOT NULL,
  `tgl_buat` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `sistem_bank_soal`
--

INSERT INTO `sistem_bank_soal` (`id_bank_soal`, `soal`, `pilihan`, `jawaban`, `guru_id`, `tgl_buat`) VALUES
(36, '&lt;p&gt;Bagaimana Bentuk Bumi Kita ?&lt;/p&gt;\r\n', '{&quot;A&quot;:&quot;Bulat &quot;,&quot;B&quot;:&quot;Datar&quot;,&quot;C&quot;:&quot;Kotak &quot;,&quot;D&quot;:&quot;Segitiga&quot;,&quot;E&quot;:&quot;Persegi&quot;}', 'A', 5, '13-02-2017'),
(37, '&lt;p&gt;Jika Manusia Hidup Maka ?&lt;/p&gt;\r\n', '{&quot;A&quot;:&quot;Bernafas&quot;,&quot;B&quot;:&quot;Berenang&quot;,&quot;C&quot;:&quot;Bergerak&quot;,&quot;D&quot;:&quot;Berjalan&quot;,&quot;E&quot;:&quot;Tidur&quot;}', 'A', 5, '13-02-2017');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sistem_jawaban`
--

CREATE TABLE `sistem_jawaban` (
  `id_jawaban` int(11) NOT NULL,
  `jawaban` varchar(100) NOT NULL,
  `soal_id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `waktu_mengerjakan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `sistem_jawaban`
--

INSERT INTO `sistem_jawaban` (`id_jawaban`, `jawaban`, `soal_id`, `siswa_id`, `waktu_mengerjakan`) VALUES
(3, 'A,B', 6, 15, '13-02-2017');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sistem_kelas`
--

CREATE TABLE `sistem_kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `sistem_kelas`
--

INSERT INTO `sistem_kelas` (`id_kelas`, `nama_kelas`) VALUES
(7, 'SI-5');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sistem_nilai`
--

CREATE TABLE `sistem_nilai` (
  `id_nilai` int(11) NOT NULL,
  `nilai` varchar(20) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_soal` int(11) NOT NULL,
  `id_jawaban` int(11) NOT NULL,
  `tgl_input` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `sistem_nilai`
--

INSERT INTO `sistem_nilai` (`id_nilai`, `nilai`, `id_siswa`, `id_soal`, `id_jawaban`, `tgl_input`) VALUES
(3, '50', 15, 6, 3, '13-02-2017');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sistem_pengumuman`
--

CREATE TABLE `sistem_pengumuman` (
  `id_pengumuman` int(11) NOT NULL,
  `isi` text NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `tgl_input` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `sistem_pengumuman`
--

INSERT INTO `sistem_pengumuman` (`id_pengumuman`, `isi`, `id_kelas`, `id_guru`, `tgl_input`) VALUES
(2, '&lt;p&gt;Contoh Pengumuman&lt;/p&gt;\r\n', 7, 5, '13-02-2017');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sistem_reset`
--

CREATE TABLE `sistem_reset` (
  `id_reset` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `id_jawaban` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sistem_sms`
--

CREATE TABLE `sistem_sms` (
  `id_sms` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL DEFAULT '0',
  `guru_id` int(11) NOT NULL DEFAULT '0',
  `id_ujian` int(11) NOT NULL DEFAULT '0',
  `tgl_input` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `sistem_sms`
--

INSERT INTO `sistem_sms` (`id_sms`, `id_kelas`, `guru_id`, `id_ujian`, `tgl_input`, `status`) VALUES
(1, 7, 5, 6, '14-02-2017', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sistem_soal`
--

CREATE TABLE `sistem_soal` (
  `id_soal` int(11) NOT NULL,
  `judul_soal` varchar(20) NOT NULL,
  `bank_soal` varchar(100) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `nilai_per_soal` int(20) NOT NULL,
  `nilai_lulus` int(20) NOT NULL,
  `tgl_buat` varchar(30) NOT NULL,
  `guru_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `sistem_soal`
--

INSERT INTO `sistem_soal` (`id_soal`, `judul_soal`, `bank_soal`, `id_kelas`, `nilai_per_soal`, `nilai_lulus`, `tgl_buat`, `guru_id`) VALUES
(6, 'UTS 2017', '36,37', 7, 50, 50, '13-02-2017', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_admin`
--

CREATE TABLE `user_admin` (
  `id_admin` int(11) NOT NULL,
  `nama_admin` varchar(80) NOT NULL,
  `user_admin` varchar(100) NOT NULL,
  `pass_admin` varchar(100) NOT NULL,
  `tgl_buat` varchar(20) NOT NULL,
  `log_masuk` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_admin`
--

INSERT INTO `user_admin` (`id_admin`, `nama_admin`, `user_admin`, `pass_admin`, `tgl_buat`, `log_masuk`) VALUES
(2, 'Indra Gunanda', 'admin', '%^JOBExRCrdPg', '13-02-2017', '26-02-2017');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_guru`
--

CREATE TABLE `user_guru` (
  `id_guru` int(11) NOT NULL,
  `nama_guru` varchar(70) NOT NULL,
  `user_guru` varchar(80) NOT NULL,
  `pass_guru` varchar(100) NOT NULL,
  `no_guru` varchar(40) NOT NULL,
  `nip_guru` varchar(40) NOT NULL,
  `tgl_buat` varchar(20) NOT NULL,
  `log_masuk` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_guru`
--

INSERT INTO `user_guru` (`id_guru`, `nama_guru`, `user_guru`, `pass_guru`, `no_guru`, `nip_guru`, `tgl_buat`, `log_masuk`) VALUES
(5, 'Citra', 'guru01', '%^og9VH1ZOQFc', '081214267695', '10515211', '13-02-2017', '26-02-2017');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_siswa`
--

CREATE TABLE `user_siswa` (
  `id_siswa` int(11) NOT NULL,
  `nama_siswa` varchar(70) NOT NULL,
  `user_siswa` varchar(80) NOT NULL,
  `pass_siswa` varchar(120) NOT NULL,
  `no_siswa` varchar(50) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `tgl_buat` varchar(20) NOT NULL,
  `log_masuk` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_siswa`
--

INSERT INTO `user_siswa` (`id_siswa`, `nama_siswa`, `user_siswa`, `pass_siswa`, `no_siswa`, `kelas_id`, `tgl_buat`, `log_masuk`) VALUES
(15, 'Indra Gunanda', 'siswa01', '%^VUIWTqGq3Jo', '081223395317', 7, '13-02-2017', '26-02-2017');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log_reset`
--
ALTER TABLE `log_reset`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `sistem_bank_soal`
--
ALTER TABLE `sistem_bank_soal`
  ADD PRIMARY KEY (`id_bank_soal`),
  ADD KEY `guru_id` (`guru_id`);

--
-- Indexes for table `sistem_jawaban`
--
ALTER TABLE `sistem_jawaban`
  ADD PRIMARY KEY (`id_jawaban`),
  ADD KEY `soal_id` (`soal_id`),
  ADD KEY `siswa_id` (`siswa_id`);

--
-- Indexes for table `sistem_kelas`
--
ALTER TABLE `sistem_kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD UNIQUE KEY `nama_kelas` (`nama_kelas`);

--
-- Indexes for table `sistem_nilai`
--
ALTER TABLE `sistem_nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_soal` (`id_soal`),
  ADD KEY `id_jawaban` (`id_jawaban`);

--
-- Indexes for table `sistem_pengumuman`
--
ALTER TABLE `sistem_pengumuman`
  ADD PRIMARY KEY (`id_pengumuman`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indexes for table `sistem_reset`
--
ALTER TABLE `sistem_reset`
  ADD PRIMARY KEY (`id_reset`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_soal` (`id_jawaban`),
  ADD KEY `id_soal_2` (`id_jawaban`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indexes for table `sistem_sms`
--
ALTER TABLE `sistem_sms`
  ADD PRIMARY KEY (`id_sms`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `guru_id` (`guru_id`),
  ADD KEY `id_ujian` (`id_ujian`);

--
-- Indexes for table `sistem_soal`
--
ALTER TABLE `sistem_soal`
  ADD PRIMARY KEY (`id_soal`),
  ADD KEY `guru_id` (`guru_id`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `user_admin`
--
ALTER TABLE `user_admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `user_admin` (`user_admin`);

--
-- Indexes for table `user_guru`
--
ALTER TABLE `user_guru`
  ADD PRIMARY KEY (`id_guru`),
  ADD UNIQUE KEY `user_guru` (`user_guru`);

--
-- Indexes for table `user_siswa`
--
ALTER TABLE `user_siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `user_siswa` (`user_siswa`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `log_reset`
--
ALTER TABLE `log_reset`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sistem_bank_soal`
--
ALTER TABLE `sistem_bank_soal`
  MODIFY `id_bank_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `sistem_jawaban`
--
ALTER TABLE `sistem_jawaban`
  MODIFY `id_jawaban` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `sistem_kelas`
--
ALTER TABLE `sistem_kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `sistem_nilai`
--
ALTER TABLE `sistem_nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `sistem_pengumuman`
--
ALTER TABLE `sistem_pengumuman`
  MODIFY `id_pengumuman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sistem_reset`
--
ALTER TABLE `sistem_reset`
  MODIFY `id_reset` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sistem_sms`
--
ALTER TABLE `sistem_sms`
  MODIFY `id_sms` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sistem_soal`
--
ALTER TABLE `sistem_soal`
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user_admin`
--
ALTER TABLE `user_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_guru`
--
ALTER TABLE `user_guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user_siswa`
--
ALTER TABLE `user_siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `sistem_bank_soal`
--
ALTER TABLE `sistem_bank_soal`
  ADD CONSTRAINT `sistem_bank_soal_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `user_guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sistem_jawaban`
--
ALTER TABLE `sistem_jawaban`
  ADD CONSTRAINT `sistem_jawaban_ibfk_1` FOREIGN KEY (`soal_id`) REFERENCES `sistem_soal` (`id_soal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sistem_jawaban_ibfk_2` FOREIGN KEY (`siswa_id`) REFERENCES `user_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sistem_nilai`
--
ALTER TABLE `sistem_nilai`
  ADD CONSTRAINT `sistem_nilai_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `user_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sistem_nilai_ibfk_2` FOREIGN KEY (`id_soal`) REFERENCES `sistem_soal` (`id_soal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sistem_nilai_ibfk_3` FOREIGN KEY (`id_jawaban`) REFERENCES `sistem_jawaban` (`id_jawaban`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sistem_pengumuman`
--
ALTER TABLE `sistem_pengumuman`
  ADD CONSTRAINT `sistem_pengumuman_ibfk_1` FOREIGN KEY (`id_guru`) REFERENCES `user_guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sistem_pengumuman_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `sistem_kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sistem_reset`
--
ALTER TABLE `sistem_reset`
  ADD CONSTRAINT `sistem_reset_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `user_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sistem_reset_ibfk_2` FOREIGN KEY (`id_jawaban`) REFERENCES `sistem_jawaban` (`id_jawaban`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sistem_reset_ibfk_3` FOREIGN KEY (`id_guru`) REFERENCES `user_guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sistem_sms`
--
ALTER TABLE `sistem_sms`
  ADD CONSTRAINT `sistem_sms_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `user_guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sistem_sms_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `sistem_kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sistem_sms_ibfk_3` FOREIGN KEY (`id_ujian`) REFERENCES `sistem_soal` (`id_soal`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sistem_soal`
--
ALTER TABLE `sistem_soal`
  ADD CONSTRAINT `sistem_soal_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `user_guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sistem_soal_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `sistem_kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_siswa`
--
ALTER TABLE `user_siswa`
  ADD CONSTRAINT `user_siswa_ibfk_1` FOREIGN KEY (`kelas_id`) REFERENCES `sistem_kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

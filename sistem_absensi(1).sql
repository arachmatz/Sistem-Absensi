-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2021 at 05:56 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistem_absensi`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int(11) NOT NULL,
  `tanggal_absensi` datetime NOT NULL,
  `keterangan_absensi` varchar(6) NOT NULL,
  `status_absensi` varchar(10) NOT NULL,
  `id_jadwal_absensi` int(11) NOT NULL,
  `nis_absensi` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `tanggal_absensi`, `keterangan_absensi`, `status_absensi`, `id_jadwal_absensi`, `nis_absensi`) VALUES
(1, '2020-01-21 11:27:50', 'I', 'terbuka', 1, '2017010001'),
(2, '2020-01-21 11:27:50', 'O', 'terbuka', 1, '2017010002'),
(3, '2020-01-21 11:27:50', 'O', 'terbuka', 1, '2017010008'),
(4, '2020-01-21 11:27:50', 'H', 'terbuka', 1, '2017010009'),
(5, '2020-01-21 11:27:50', 'O', 'terbuka', 1, '2017010010'),
(6, '2020-01-21 11:27:50', 'O', 'terbuka', 1, '2017010011'),
(7, '2020-01-21 11:27:50', 'O', 'terbuka', 1, '2017010020'),
(8, '2020-01-21 11:27:50', 'O', 'terbuka', 1, '2017010030'),
(9, '2020-01-21 11:39:05', 'O', 'terbuka', 2, '2017010001'),
(10, '2020-01-21 11:39:05', 'O', 'terbuka', 2, '2017010002'),
(11, '2020-01-21 11:39:05', 'O', 'terbuka', 2, '2017010008'),
(12, '2020-01-21 11:39:05', 'O', 'terbuka', 2, '2017010009'),
(13, '2020-01-21 11:39:05', 'O', 'terbuka', 2, '2017010010'),
(14, '2020-01-21 11:39:05', 'O', 'terbuka', 2, '2017010011'),
(15, '2020-01-21 11:39:05', 'O', 'terbuka', 2, '2017010020'),
(16, '2020-01-21 11:39:05', 'O', 'terbuka', 2, '2017010030'),
(17, '2020-01-21 11:44:13', 'A', 'terbuka', 3, '2017020011');

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `nip` varchar(10) NOT NULL,
  `nama_guru` varchar(25) NOT NULL,
  `tanggal_lahir_guru` date NOT NULL,
  `jenis_kelamin_guru` varchar(1) NOT NULL,
  `alamat_guru` text NOT NULL,
  `foto_guru` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`nip`, `nama_guru`, `tanggal_lahir_guru`, `jenis_kelamin_guru`, `alamat_guru`, `foto_guru`) VALUES
('1220100000', 'Marul Waid, S. Ag', '1983-07-14', 'L', 'Tangerang', 'user/guru/1220100000_Marul Waid, S. Ag.png'),
('1220100001', 'Ade Irwan Setiawan S.pd', '1987-04-17', 'L', 'Bogor', 'user/guru/1220100001_Ade Irwan Setiawan S.pd.png'),
('1220100002', 'Tita Nur Hidayah S.pd', '1987-08-07', 'P', 'Tangerang', 'user/guru/1220100002_Tita Nur Hidayah.jpg'),
('1220100009', 'Nur Asma S E., M.M', '1987-07-15', 'P', 'Tangerang', 'user/guru/1220100009_Nur Asma S E., M.M.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(11) NOT NULL,
  `hari` varchar(15) NOT NULL,
  `jam` varchar(1) NOT NULL,
  `id_kelas_jadwal` varchar(10) NOT NULL,
  `nip_jadwal` varchar(10) NOT NULL,
  `kode_mapel_jadwal` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `hari`, `jam`, `id_kelas_jadwal`, `nip_jadwal`, `kode_mapel_jadwal`) VALUES
(1, 'selasa', '1', '12_IPA_1', '1220100002', 'A009'),
(2, 'selasa', '2', '12_IPA_1', '1220100001', 'A0001'),
(3, 'selasa', '3', '12_IPS_1', '1220100001', 'A0001'),
(4, 'selasa', '1', '12_IPS_1', '1220100002', 'N0002'),
(5, 'selasa', '2', '12_IPS_1', '1220100001', 'A0002'),
(6, 'selasa', '3', '12_IPA_1', '1220100000', 'A0002');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` varchar(10) NOT NULL,
  `nama_kelas` varchar(50) NOT NULL,
  `wali_kelas` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `wali_kelas`) VALUES
('12_IPA_1', '12 Ilmu Pengetahuan Alam 1', '1220100000'),
('12_IPS_1', '12 Ilmu Pengetahuan Sosial 1', '1220100002'),
('12_IPS_2', '12 Ilmu Pengetahuan Sosial 2', '1220100009');

-- --------------------------------------------------------

--
-- Table structure for table `mata_pelajaran`
--

CREATE TABLE `mata_pelajaran` (
  `kode_mapel` varchar(10) NOT NULL,
  `nama_mapel` varchar(50) NOT NULL,
  `jenis_mapel` varchar(20) NOT NULL,
  `keterangan_mapel` text NOT NULL,
  `tingkat_mapel` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mata_pelajaran`
--

INSERT INTO `mata_pelajaran` (`kode_mapel`, `nama_mapel`, `jenis_mapel`, `keterangan_mapel`, `tingkat_mapel`) VALUES
('A0001', 'Matematika', 'adaptif', '-', '1_2_3'),
('A0002', 'Bahasa Indonesia', 'adaptif', '-', '1_2_3'),
('A0003', 'Bahasa Inggris', 'adaptif', '-', '1_2_3'),
('A009', 'Biologi', 'adaptif', 'Salah satu cabang dari IPA', '2_3'),
('A010', 'Ekonomi', 'adaptif', 'Salah satu cabang dari IPS', '2_3'),
('N0002', 'Agama Islam', 'normatif', 'Mempelajari sejarah islam', '1_2_3');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `nis` varchar(10) NOT NULL,
  `nama_siswa` varchar(25) NOT NULL,
  `tanggal_lahir_siswa` date NOT NULL,
  `jenis_kelamin_siswa` varchar(1) NOT NULL,
  `alamat_siswa` text NOT NULL,
  `id_kelas_siswa` varchar(25) NOT NULL,
  `foto_siswa` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nis`, `nama_siswa`, `tanggal_lahir_siswa`, `jenis_kelamin_siswa`, `alamat_siswa`, `id_kelas_siswa`, `foto_siswa`) VALUES
('2017010001', 'Adam Joko S.', '2002-05-19', 'L', 'Pondok Cabe', '12_IPA_1', 'user/siswa/2012010001_Adam Joko S._12_IPA_1.png'),
('2017010002', 'Ayu Wahyuni', '2002-08-14', 'P', 'Pamulang', '12_IPA_1', 'user/siswa/2012010002_Ayu Wahyuni_12_IPA_1.jpg'),
('2017010008', 'Farid Gumelar', '2002-12-10', 'L', 'Kedaung, Ciputat', '12_IPA_1', 'user/siswa/2017010008_Farid Gumelar_12_IPA_1.png'),
('2017010009', 'Dinda Nur Ishma', '2002-06-26', 'P', 'Ciputat', '12_IPA_1', 'user/siswa/2017010009_Dinda Nur Ishma_12_IPA_1.jpg'),
('2017010010', 'Imam Hanafi', '2001-01-22', 'L', 'Pondok Cabe', '12_IPA_1', 'user/siswa/2017010010_Imam Hanafi_12_IPA_1.png'),
('2017010011', 'Putri Ajeng HK', '2001-06-12', 'L', 'Pamulang Indah', '12_IPA_1', 'user/siswa/2017010011_Putri Ajeng HK_12_IPA_1.jpg'),
('2017010020', 'Khalda Livia Zahra', '2002-06-18', 'P', 'Cinere, Depok', '12_IPA_1', 'user/siswa/2017010020_Khalda Livia Zahra_12_IPA_1.jpg'),
('2017010030', 'Faturohman', '2002-01-15', 'L', 'Parung, Depok', '12_IPA_1', 'user/siswa/2017010030_Faturohman_12_IPA_1.png'),
('2017020011', 'Umriah Lestari', '2002-06-16', 'P', 'Cimanggis, Ciputat', '12_IPS_1', 'user/siswa/2017020011_Umriah Lestari_12_IPS_1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(25) DEFAULT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(32) NOT NULL,
  `hak_akses` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `username`, `password`, `hak_akses`) VALUES
(9, NULL, '0120121212', '87654321', 'Admin'),
(16, 'Adam Joko S.', '2017010001', '20020519', 'Siswa'),
(17, 'Ayu Wahyuni', '2017010002', '20020814', 'Siswa'),
(18, 'Dinda Nur Ishma', '2017010009', '12345678', 'Siswa'),
(19, 'Farid Gumelar', '2017010008', '20021210', 'Siswa'),
(20, 'Imam Hanafi', '2017010010', '20010122', 'Siswa'),
(21, 'Khalda Livia Zahra', '2017010020', '20020618', 'Siswa'),
(22, 'Faturohman', '2017010030', '20020115', 'Siswa'),
(23, 'Putri Ajeng HK', '2017010011', '20010612', 'Siswa'),
(24, 'Raka Saputra', '2017010012', '20010130', 'Siswa'),
(25, 'Puri Larassati', '2017010013', '20200911', 'Siswa'),
(26, 'Umriah Lestari', '2017020011', '20020616', 'Siswa'),
(27, 'Marul Waid, S. Ag', '1220100000', '12345678', 'WaliKelas'),
(28, 'Ade Irwan Setiawan S.pd', '1220100001', '19870417', 'Guru'),
(29, 'Tita Nur Hidayah S.pd', '1220100002', '19870807', 'WaliKelas'),
(30, 'Nur Asma S E., M.M', '1220100009', '19870715', 'WaliKelas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`nip`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD PRIMARY KEY (`kode_mapel`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

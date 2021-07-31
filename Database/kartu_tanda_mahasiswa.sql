-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Jul 2021 pada 04.26
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kartu_tanda_mahasiswa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_fungsi`
--

CREATE TABLE `tb_fungsi` (
  `id_fungsi` int(11) NOT NULL,
  `nama_fungsi` varchar(100) NOT NULL,
  `deskripsi_fungsi` text NOT NULL,
  `ikon_fungsi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_fungsi`
--

INSERT INTO `tb_fungsi` (`id_fungsi`, `nama_fungsi`, `deskripsi_fungsi`, `ikon_fungsi`) VALUES
(1, 'Secara Administrasi', '<p>Kartu Tanda digunakan untuk tanda pengenal yang sah</p>', 'tag');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jurusan`
--

CREATE TABLE `tb_jurusan` (
  `id_jurusan` int(11) NOT NULL,
  `nama_jurusan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_jurusan`
--

INSERT INTO `tb_jurusan` (`id_jurusan`, `nama_jurusan`) VALUES
(1, 'JURUSAN 1'),
(2, 'JURUSAN 2'),
(3, 'JURUSAN 3'),
(4, 'JURUSAN 4'),
(5, 'JURUSAN 5');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_ktm`
--

CREATE TABLE `tb_ktm` (
  `id_ktm` int(11) NOT NULL,
  `nim_mahasiswa` varchar(50) NOT NULL,
  `tahun_ktm` varchar(4) NOT NULL,
  `front_file` varchar(100) NOT NULL,
  `beck_file` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_ktm`
--

INSERT INTO `tb_ktm` (`id_ktm`, `nim_mahasiswa`, `tahun_ktm`, `front_file`, `beck_file`) VALUES
(6, '3265988410', '2021', 'nama-hacking-indonesia-3265988410.png', 'nama-hacking-indonesia-3265988410-beck.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_mahasiswa`
--

CREATE TABLE `tb_mahasiswa` (
  `id_mahasiswa` int(11) NOT NULL,
  `nama_mahasiswa` varchar(50) NOT NULL,
  `email_mahasiswa` varchar(50) NOT NULL,
  `nim_mahasiswa` varchar(10) NOT NULL,
  `password_mahasiswa` varchar(100) NOT NULL,
  `gender` char(1) NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `angkatan_mahasiswa` varchar(4) NOT NULL,
  `foto_mahasiswa` varchar(100) NOT NULL,
  `qr_code` varchar(100) NOT NULL,
  `jurusan_mahasiswa` int(1) NOT NULL,
  `tgl_input` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_mahasiswa`
--

INSERT INTO `tb_mahasiswa` (`id_mahasiswa`, `nama_mahasiswa`, `email_mahasiswa`, `nim_mahasiswa`, `password_mahasiswa`, `gender`, `tempat_lahir`, `tgl_lahir`, `alamat`, `angkatan_mahasiswa`, `foto_mahasiswa`, `qr_code`, `jurusan_mahasiswa`, `tgl_input`) VALUES
(104, 'Nama Hacking indonesia', 'hack@hack.com', '3265988410', '$2y$10$PnUEgolEqCDh/ZPY0C0RF.5DfQQjqKJRRlS95Bd1ndDm34pycWyfm', 'L', 'NKRI', '2021-07-12', 'Alamatnya Dimana Mana Boleh Asal Ganteng', '2021', '3265988410.png', 'nama-hacking-indonesia-3265988410.png', 1, '2021-07-12 09:21:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengaturan`
--

CREATE TABLE `tb_pengaturan` (
  `id_website` int(11) NOT NULL,
  `judul_website` varchar(100) NOT NULL,
  `nama_website` varchar(100) NOT NULL,
  `email_website` varchar(100) NOT NULL,
  `pass_email_web` varchar(100) NOT NULL,
  `server_email` varchar(100) DEFAULT NULL,
  `deskripsi_website` text NOT NULL,
  `author_website` varchar(100) NOT NULL DEFAULT 'ibnusodik049@gmail.com',
  `logo_website` varchar(100) NOT NULL,
  `tahun_buat` year(4) NOT NULL,
  `konten_homepage` mediumtext NOT NULL,
  `peta_lokasi` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pengaturan`
--

INSERT INTO `tb_pengaturan` (`id_website`, `judul_website`, `nama_website`, `email_website`, `pass_email_web`, `server_email`, `deskripsi_website`, `author_website`, `logo_website`, `tahun_buat`, `konten_homepage`, `peta_lokasi`) VALUES
(1, 'KTM GB', 'Aplikasi Kartu Tanda', 'sikatam@goblog252.com', 'SKTM IS me 252', 'mail.goblog252.com', 'Aplikasi kartu tanda mahasiswa dibuat untuk otomatisasi dalam pengelolaan serta pembuatan kartu tanda mahasiswa secara online', 'ibnusodik049@gmail.com', '1623436339.png', 2020, '<h3 class=\"text-justify\" style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-weight: 500; font-size: 1.75rem; padding: 0px; border: 0px; outline: 0px; font-family: Roboto, sans-serif;\">Aplikasi kartu tanda mahasiswa dibuat untuk otomatisasi dalam pengelolaan serta pembuatan kartu tanda mahasiswa secara online</h3>', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_reset_pass`
--

CREATE TABLE `tb_reset_pass` (
  `id_reset` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `kode_reset` varchar(50) NOT NULL,
  `level` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_sosmed`
--

CREATE TABLE `tb_sosmed` (
  `id_sosmed` int(11) NOT NULL,
  `id_pemilik` int(11) NOT NULL,
  `jenis_sosmed` varchar(50) NOT NULL,
  `link_sosmed` varchar(150) NOT NULL,
  `ikon_sosmed` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_sosmed`
--

INSERT INTO `tb_sosmed` (`id_sosmed`, `id_pemilik`, `jenis_sosmed`, `link_sosmed`, `ikon_sosmed`) VALUES
(1, 1, 'Website', 'https://goblog252.com', 'globe');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_template`
--

CREATE TABLE `tb_template` (
  `id_template` int(11) NOT NULL,
  `front_template` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `beck_template` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kepsek` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanda_tangan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stempel` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb_template`
--

INSERT INTO `tb_template` (`id_template`, `front_template`, `beck_template`, `nama_kepsek`, `tanda_tangan`, `stempel`) VALUES
(1, 'template-depan.jpg', 'template-belakang.jpg', 'Ibnu Sodik, S.Kom.', 'tanda-tangan.png', 'stempel.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `username`, `email`, `password`, `full_name`, `foto`, `level`) VALUES
(1, 'admin', 'dixos252@gmail.com', '$2y$10$BrPJw9meJK16/P0qyXSHQOQ1DGa4oHDTY/6j8sE6jgHU0QVFgg/zy', 'Administrator (Ibnu Sodik)', 'is01252-1623437203.jpg', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_fungsi`
--
ALTER TABLE `tb_fungsi`
  ADD PRIMARY KEY (`id_fungsi`);

--
-- Indeks untuk tabel `tb_jurusan`
--
ALTER TABLE `tb_jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indeks untuk tabel `tb_ktm`
--
ALTER TABLE `tb_ktm`
  ADD PRIMARY KEY (`id_ktm`);

--
-- Indeks untuk tabel `tb_mahasiswa`
--
ALTER TABLE `tb_mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`);

--
-- Indeks untuk tabel `tb_pengaturan`
--
ALTER TABLE `tb_pengaturan`
  ADD PRIMARY KEY (`id_website`);

--
-- Indeks untuk tabel `tb_reset_pass`
--
ALTER TABLE `tb_reset_pass`
  ADD PRIMARY KEY (`id_reset`);

--
-- Indeks untuk tabel `tb_sosmed`
--
ALTER TABLE `tb_sosmed`
  ADD PRIMARY KEY (`id_sosmed`);

--
-- Indeks untuk tabel `tb_template`
--
ALTER TABLE `tb_template`
  ADD PRIMARY KEY (`id_template`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_fungsi`
--
ALTER TABLE `tb_fungsi`
  MODIFY `id_fungsi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_jurusan`
--
ALTER TABLE `tb_jurusan`
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_ktm`
--
ALTER TABLE `tb_ktm`
  MODIFY `id_ktm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_mahasiswa`
--
ALTER TABLE `tb_mahasiswa`
  MODIFY `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT untuk tabel `tb_pengaturan`
--
ALTER TABLE `tb_pengaturan`
  MODIFY `id_website` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_reset_pass`
--
ALTER TABLE `tb_reset_pass`
  MODIFY `id_reset` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_sosmed`
--
ALTER TABLE `tb_sosmed`
  MODIFY `id_sosmed` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_template`
--
ALTER TABLE `tb_template`
  MODIFY `id_template` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

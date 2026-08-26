-- DROP TABLE IF EXISTS `aturan_skoring`;
-- DROP TABLE IF EXISTS `berkas`;
-- DROP TABLE IF EXISTS `penilaian`;
-- DROP TABLE IF EXISTS `pengalaman_kerja`;
-- DROP TABLE IF EXISTS `organisasi`;
-- DROP TABLE IF EXISTS `pendidikan`;
-- DROP TABLE IF EXISTS `alternatif`;
-- DROP TABLE IF EXISTS `sub_kriteria`;
-- DROP TABLE IF EXISTS `kriteria`;
-- DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `level` enum('admin','atasan','pelamar') NOT NULL DEFAULT 'pelamar',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `kriteria` (
  `id_kriteria` int(11) NOT NULL AUTO_INCREMENT,
  `kode_kriteria` varchar(10) NOT NULL,
  `nama_kriteria` varchar(100) NOT NULL,
  `bobot` float NOT NULL,
  `jenis` enum('Benefit','Cost') NOT NULL,
  PRIMARY KEY (`id_kriteria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `sub_kriteria` (
  `id_sub` int(11) NOT NULL AUTO_INCREMENT,
  `id_kriteria` int(11) NOT NULL,
  `nama_sub` varchar(100) NOT NULL,
  `nilai` float NOT NULL,
  PRIMARY KEY (`id_sub`),
  KEY `id_kriteria` (`id_kriteria`),
  CONSTRAINT `sub_kriteria_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `alternatif` (
  `id_alternatif` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `nama_alternatif` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `jarak_rumah` int(11) DEFAULT NULL,
  `riwayat_penyakit` enum('Ya','Tidak') DEFAULT 'Tidak',
  `riwayat_penyakit_detail` text DEFAULT NULL,
  PRIMARY KEY (`id_alternatif`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `alternatif_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `penilaian` (
  `id_penilaian` int(11) NOT NULL AUTO_INCREMENT,
  `id_alternatif` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `id_sub` int(11) NOT NULL,
  PRIMARY KEY (`id_penilaian`),
  KEY `id_alternatif` (`id_alternatif`),
  KEY `id_kriteria` (`id_kriteria`),
  KEY `id_sub` (`id_sub`),
  CONSTRAINT `penilaian_ibfk_1` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`) ON DELETE CASCADE,
  CONSTRAINT `penilaian_ibfk_2` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE,
  CONSTRAINT `penilaian_ibfk_3` FOREIGN KEY (`id_sub`) REFERENCES `sub_kriteria` (`id_sub`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `pengalaman_kerja` (
  `id_pengalaman` int(11) NOT NULL AUTO_INCREMENT,
  `id_alternatif` int(11) NOT NULL,
  `nama_perusahaan` varchar(150) NOT NULL,
  `posisi` varchar(100) NOT NULL,
  `tahun_mulai` year(4) NOT NULL,
  `tahun_selesai` year(4) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  PRIMARY KEY (`id_pengalaman`),
  KEY `id_alternatif` (`id_alternatif`),
  CONSTRAINT `pengalaman_kerja_ibfk_1` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `pendidikan` (
  `id_pendidikan` int(11) NOT NULL AUTO_INCREMENT,
  `id_alternatif` int(11) NOT NULL,
  `jenjang` varchar(20) NOT NULL,
  `nama_sekolah` varchar(150) NOT NULL,
  `jurusan` varchar(100) DEFAULT NULL,
  `tahun_masuk` year(4) NOT NULL,
  `tahun_lulus` year(4) DEFAULT NULL,
  `ipk` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_pendidikan`),
  KEY `id_alternatif` (`id_alternatif`),
  CONSTRAINT `pendidikan_ibfk_1` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `organisasi` (
  `id_organisasi` int(11) NOT NULL AUTO_INCREMENT,
  `id_alternatif` int(11) NOT NULL,
  `nama_organisasi` varchar(150) NOT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `tahun_mulai` year(4) NOT NULL,
  `tahun_selesai` year(4) DEFAULT NULL,
  PRIMARY KEY (`id_organisasi`),
  KEY `id_alternatif` (`id_alternatif`),
  CONSTRAINT `organisasi_ibfk_1` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `berkas` (
  `id_berkas` int(11) NOT NULL AUTO_INCREMENT,
  `id_alternatif` int(11) NOT NULL,
  `nama_berkas` varchar(200) NOT NULL,
  `jenis_berkas` varchar(50) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `status_validasi` enum('pending','valid','invalid') DEFAULT 'pending',
  `catatan_hrd` text DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_berkas`),
  KEY `id_alternatif` (`id_alternatif`),
  CONSTRAINT `berkas_ibfk_1` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `aturan_skoring` (
  `id_aturan` int(11) NOT NULL AUTO_INCREMENT,
  `id_kriteria` int(11) NOT NULL,
  `id_sub` int(11) NOT NULL,
  `sumber_data` enum('pengalaman_kerja','organisasi','berkas','profil','pendidikan') NOT NULL,
  `field_sumber` varchar(50) NOT NULL,
  `operator` enum('>=','<=','=','>','<','between') NOT NULL,
  `nilai_min` varchar(50) DEFAULT NULL,
  `nilai_max` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_aturan`),
  KEY `id_kriteria` (`id_kriteria`),
  KEY `id_sub` (`id_sub`),
  CONSTRAINT `aturan_skoring_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE,
  CONSTRAINT `aturan_skoring_ibfk_2` FOREIGN KEY (`id_sub`) REFERENCES `sub_kriteria` (`id_sub`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =======================
-- SEED DATA
-- =======================

INSERT INTO `users` (`username`, `password`, `nama`, `level`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin'),
('atasan', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pimpinan', 'atasan'),
('ahmad', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Ahmad Fauzi', 'pelamar'),
('siti', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Siti Rahmawati', 'pelamar'),
('budi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Budi Santoso', 'pelamar'),
('dewi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Dewi Lestari', 'pelamar'),
('rudi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Rudi Hermawan', 'pelamar');

INSERT INTO `kriteria` (`kode_kriteria`, `nama_kriteria`, `bobot`, `jenis`) VALUES
('C01', 'Masa Kerja', 15, 'Benefit'),
('C02', 'Pendidikan', 10, 'Benefit'),
('C03', 'Tes Tulis', 20, 'Benefit'),
('C04', 'Wawancara', 10, 'Benefit'),
('C05', 'Pengalaman Organisasi', 10, 'Benefit'),
('C06', 'Jarak Rumah', 10, 'Cost'),
('C07', 'Riwayat Penyakit', 10, 'Benefit'),
('C08', 'Kelengkapan Berkas', 15, 'Benefit');

INSERT INTO `sub_kriteria` (`id_kriteria`, `nama_sub`, `nilai`) VALUES
-- C01: Masa Kerja
(1, '> 8 Tahun', 5),
(1, '5-8 Tahun', 4),
(1, '3-5 Tahun', 3),
(1, '1-3 Tahun', 2),
(1, '< 1 Tahun', 1),
-- C02: Pendidikan
(2, 'S3', 5),
(2, 'S2', 4),
(2, 'S1', 3),
(2, 'D3', 2),
(2, 'SMA', 1),
-- C03: Tes Tulis
(3, 'Sangat Baik', 5),
(3, 'Baik', 4),
(3, 'Cukup', 3),
(3, 'Kurang', 2),
(3, 'Sangat Kurang', 1),
-- C04: Wawancara
(4, 'Sangat Baik', 5),
(4, 'Baik', 4),
(4, 'Cukup', 3),
(4, 'Kurang', 2),
(4, 'Sangat Kurang', 1),
-- C05: Organisasi
(5, '>= 4 Organisasi', 5),
(5, '3 Organisasi', 4),
(5, '2 Organisasi', 3),
(5, '1 Organisasi', 2),
(5, 'Tidak Ada', 1),
-- C06: Jarak Rumah
(6, '> 20 km', 5),
(6, '10-20 km', 4),
(6, '5-10 km', 3),
(6, '2-5 km', 2),
(6, '< 2 km', 1),
-- C07: Riwayat Penyakit
(7, 'Tidak Ada', 5),
(7, 'Ada', 1),
-- C08: Kelengkapan Berkas
(8, '> 6 Berkas Valid', 5),
(8, '5-6 Berkas Valid', 4),
(8, '3-4 Berkas Valid', 3),
(8, '1-2 Berkas Valid', 2),
(8, 'Tidak Ada', 1);

INSERT INTO `alternatif` (`id_user`, `nama_alternatif`, `email`, `no_telp`, `alamat`, `jarak_rumah`, `riwayat_penyakit`) VALUES
(3, 'Ahmad Fauzi', 'ahmad@email.com', '081234567891', 'Jl. Merdeka No. 10, Jakarta', 3, 'Tidak'),
(4, 'Siti Rahmawati', 'siti@email.com', '081234567892', 'Jl. Sudirman No. 25, Bandung', 7, 'Tidak'),
(5, 'Budi Santoso', 'budi@email.com', '081234567893', 'Jl. Gatot Subroto No. 5, Surabaya', 15, 'Ya'),
(6, 'Dewi Lestari', 'dewi@email.com', '081234567894', 'Jl. Diponegoro No. 12, Yogyakarta', 1, 'Tidak'),
(7, 'Rudi Hermawan', 'rudi@email.com', '081234567895', 'Jl. Ahmad Yani No. 8, Semarang', 25, 'Tidak');

INSERT INTO `pengalaman_kerja` (`id_alternatif`, `nama_perusahaan`, `posisi`, `tahun_mulai`, `tahun_selesai`, `deskripsi`) VALUES
-- Ahmad: 5 + 7 = 12 tahun
(1, 'PT Maju Bersama', 'Staff IT', 2010, 2015, 'Bertanggung jawab atas maintenance jaringan'),
(1, 'PT Teknologi Canggih', 'Senior Developer', 2015, 2022, 'Mengembangkan aplikasi internal perusahaan'),
-- Siti: 5 + 3 = 8 tahun
(2, 'PT Sejahtera Abadi', 'Marketing Executive', 2013, 2018, 'Menangani pemasaran produk'),
(2, 'PT Kreatif Mandiri', 'Brand Manager', 2018, 2021, 'Mengelola brand awareness perusahaan'),
-- Budi: 5 tahun
(3, 'CV Karya Utama', 'Staff Keuangan', 2016, 2021, 'Mengelola administrasi keuangan'),
-- Dewi: 3 tahun
(4, 'PT Solusi Digital', 'Junior Developer', 2020, 2023, 'Mengembangkan website perusahaan'),
-- Rudi: 1 tahun
(5, 'PT Startup Baru', 'Intern', 2022, 2023, 'Membantu tim pengembangan produk');

INSERT INTO `pendidikan` (`id_alternatif`, `jenjang`, `nama_sekolah`, `jurusan`, `tahun_masuk`, `tahun_lulus`, `ipk`) VALUES
(1, 'S1', 'Universitas Indonesia', 'Teknik Informatika', 2010, 2014, '3.45'),
(2, 'S1', 'Universitas Gadjah Mada', 'Manajemen', 2011, 2015, '3.60'),
(3, 'D3', 'Politeknik Negeri Jakarta', 'Akuntansi', 2012, 2015, '3.30'),
(4, 'S1', 'Universitas Airlangga', 'Sistem Informasi', 2015, 2019, '3.50'),
(5, 'SMA', 'SMA Negeri 1 Jakarta', 'IPA', 2018, 2021, NULL);

INSERT INTO `organisasi` (`id_alternatif`, `nama_organisasi`, `jabatan`, `tahun_mulai`, `tahun_selesai`) VALUES
-- Ahmad: 3 organisasi
(1, 'HIMA Teknik Informatika', 'Ketua', 2011, 2012),
(1, 'BEM Universitas', 'Sekretaris', 2012, 2013),
(1, 'UKM Basket', 'Anggota', 2010, 2014),
-- Siti: 2 organisasi
(2, 'BEM Fakultas', 'Bendahara', 2012, 2013),
(2, 'UKM Musik', 'Anggota', 2011, 2015),
-- Budi: 1 organisasi
(3, 'HIMA Akuntansi', 'Anggota', 2013, 2014),
-- Dewi: 1 organisasi
(4, 'BEM Fakultas', 'Staff', 2016, 2017);

INSERT INTO `penilaian` (`id_alternatif`, `id_kriteria`, `id_sub`) VALUES
-- Data dummy pengujian SPK.
-- C01/C05/C06/C07/C08 konsisten dengan hasil AutoSkoring berdasarkan profil pelamar.
-- C02 diisi manual sesuai jenjang pendidikan. C03 (Tes Tulis) dan C04 (Wawancara) dummy manual.
-- Ahmad (C01: 12 thn, S1, C05: 3 org, C06: 3 km, C07: Tidak, C08: 0)
(1, 1, 1),  -- C01: > 8 Tahun
(1, 2, 8),  -- C02: S1
(1, 3, 11), -- C03: Sangat Baik
(1, 4, 16), -- C04: Sangat Baik
(1, 5, 22), -- C05: 3 Organisasi
(1, 6, 29), -- C06: 2-5 km
(1, 7, 31), -- C07: Tidak Ada
(1, 8, 37), -- C08: Tidak Ada
-- Siti (C01: 8 thn, S1, C05: 2 org, C06: 7 km, C07: Tidak, C08: 0)
(2, 1, 1),  -- C01: > 8 Tahun
(2, 2, 8),  -- C02: S1
(2, 3, 12), -- C03: Baik
(2, 4, 17), -- C04: Baik
(2, 5, 23), -- C05: 2 Organisasi
(2, 6, 28), -- C06: 5-10 km
(2, 7, 31), -- C07: Tidak Ada
(2, 8, 37), -- C08: Tidak Ada
-- Budi (C01: 5 thn, D3, C05: 1 org, C06: 15 km, C07: Ya, C08: 0)
(3, 1, 2),  -- C01: 5-8 Tahun
(3, 2, 9),  -- C02: D3
(3, 3, 13), -- C03: Cukup
(3, 4, 18), -- C04: Cukup
(3, 5, 24), -- C05: 1 Organisasi
(3, 6, 27), -- C06: 10-20 km
(3, 7, 32), -- C07: Ada
(3, 8, 37), -- C08: Tidak Ada
-- Dewi (C01: 3 thn, S1, C05: 1 org, C06: 1 km, C07: Tidak, C08: 0)
(4, 1, 3),  -- C01: 3-5 Tahun
(4, 2, 8),  -- C02: S1
(4, 3, 12), -- C03: Baik
(4, 4, 16), -- C04: Sangat Baik
(4, 5, 24), -- C05: 1 Organisasi
(4, 6, 30), -- C06: < 2 km
(4, 7, 31), -- C07: Tidak Ada
(4, 8, 37), -- C08: Tidak Ada
-- Rudi (C01: 1 thn, SMA, C05: 0 org, C06: 25 km, C07: Tidak, C08: 0)
(5, 1, 4),  -- C01: 1-3 Tahun
(5, 2, 10), -- C02: SMA
(5, 3, 13), -- C03: Cukup
(5, 4, 19), -- C04: Kurang
(5, 5, 25), -- C05: Tidak Ada Organisasi
(5, 6, 26), -- C06: > 20 km
(5, 7, 31), -- C07: Tidak Ada
(5, 8, 37); -- C08: Tidak Ada

INSERT INTO `aturan_skoring` (`id_kriteria`, `id_sub`, `sumber_data`, `field_sumber`, `operator`, `nilai_min`, `nilai_max`) VALUES
-- C01: Masa Kerja (sumber: pengalaman_kerja.total_tahun)
(1, 1, 'pengalaman_kerja', 'total_tahun', '>=', '8', NULL),
(1, 2, 'pengalaman_kerja', 'total_tahun', '>=', '5', NULL),
(1, 3, 'pengalaman_kerja', 'total_tahun', '>=', '3', NULL),
(1, 4, 'pengalaman_kerja', 'total_tahun', '>=', '1', NULL),
(1, 5, 'pengalaman_kerja', 'total_tahun', '>=', '0', NULL),
-- C02: Pendidikan (sumber: pendidikan.jenjang)
(2, 6, 'pendidikan', 'jenjang', '=', 'S3', NULL),
(2, 7, 'pendidikan', 'jenjang', '=', 'S2', NULL),
(2, 8, 'pendidikan', 'jenjang', '=', 'S1', NULL),
(2, 9, 'pendidikan', 'jenjang', '=', 'D3', NULL),
(2, 10, 'pendidikan', 'jenjang', '=', 'SMA', NULL),
-- C05: Organisasi (sumber: organisasi.jumlah)
(5, 21, 'organisasi', 'jumlah', '>=', '4', NULL),
(5, 22, 'organisasi', 'jumlah', '=', '3', NULL),
(5, 23, 'organisasi', 'jumlah', '=', '2', NULL),
(5, 24, 'organisasi', 'jumlah', '>=', '1', NULL),
(5, 25, 'organisasi', 'jumlah', '>=', '0', NULL),
-- C06: Jarak Rumah (sumber: profil.jarak_rumah)
(6, 26, 'profil', 'jarak_rumah', '>=', '20', NULL),
(6, 27, 'profil', 'jarak_rumah', '>=', '10', NULL),
(6, 28, 'profil', 'jarak_rumah', '>=', '5', NULL),
(6, 29, 'profil', 'jarak_rumah', '>=', '2', NULL),
(6, 30, 'profil', 'jarak_rumah', '>=', '0', NULL),
-- C07: Riwayat Penyakit (sumber: profil.riwayat_penyakit)
(7, 31, 'profil', 'riwayat_penyakit', '=', 'Tidak', NULL),
(7, 32, 'profil', 'riwayat_penyakit', '=', 'Ya', NULL),
-- C08: Kelengkapan Berkas (sumber: berkas.jumlah_valid)
(8, 33, 'berkas', 'jumlah_valid', '>=', '7', NULL),
(8, 34, 'berkas', 'jumlah_valid', '>=', '5', NULL),
(8, 35, 'berkas', 'jumlah_valid', '>=', '3', NULL),
(8, 36, 'berkas', 'jumlah_valid', '>=', '1', NULL),
(8, 37, 'berkas', 'jumlah_valid', '>=', '0', NULL);

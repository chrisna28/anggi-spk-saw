-- Migration untuk menambah kolom validasi berkas
-- Jalankan SQL ini jika database sudah ada

ALTER TABLE `berkas`
ADD COLUMN `status_validasi` enum('pending','valid','invalid') DEFAULT 'pending' AFTER `file_type`,
ADD COLUMN `catatan_hrd` text DEFAULT NULL AFTER `status_validasi`;

-- Tambah kriteria C08 Kelengkapan Berkas
INSERT INTO `kriteria` (`kode_kriteria`, `nama_kriteria`, `bobot`, `jenis`) VALUES
('C08', 'Kelengkapan Berkas', 15, 'Benefit');

-- Update bobot kriteria existing
UPDATE `kriteria` SET `bobot` = 15 WHERE `kode_kriteria` = 'C01';
UPDATE `kriteria` SET `bobot` = 10 WHERE `kode_kriteria` = 'C02';
UPDATE `kriteria` SET `bobot` = 20 WHERE `kode_kriteria` = 'C03';

-- Tambah sub_kriteria C08
INSERT INTO `sub_kriteria` (`id_kriteria`, `nama_sub`, `nilai`) VALUES
(8, '> 6 Berkas Valid', 5),
(8, '5-6 Berkas Valid', 4),
(8, '3-4 Berkas Valid', 3),
(8, '1-2 Berkas Valid', 2),
(8, 'Tidak Ada', 1);

-- Tambah aturan_skoring C08
INSERT INTO `aturan_skoring` (`id_kriteria`, `id_sub`, `sumber_data`, `field_sumber`, `operator`, `nilai_min`, `nilai_max`) VALUES
(8, 33, 'berkas', 'jumlah_valid', '>=', '7', NULL),
(8, 34, 'berkas', 'jumlah_valid', '>=', '5', NULL),
(8, 35, 'berkas', 'jumlah_valid', '>=', '3', NULL),
(8, 36, 'berkas', 'jumlah_valid', '>=', '1', NULL),
(8, 37, 'berkas', 'jumlah_valid', '>=', '0', NULL);

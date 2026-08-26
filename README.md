# SPK SAW — Sistem Penunjang Keputusan Metode Simple Additive Weighting

Sistem rekrutmen dan seleksi karyawan berbasis metode SAW (Simple Additive Weighting) dengan multi-role: HRD, Atasan, dan Pelamar.

## Tech Stack

- **Framework:** CodeIgniter 3 (PHP 7.4+ / 8.x)
- **Database:** MySQL 8.0 (via MAMP)
- **Frontend:** Bootstrap 5, Font Awesome 6, jQuery 3.6
- **Font:** Plus Jakarta Sans

## Fitur

### Role HRD (Admin)
- Manajemen kriteria, sub-kriteria, bobot, dan jenis (Benefit/Cost)
- CRUD data alternatif (kandidat pelamar)
- Input penilaian manual per kandidat
- Auto-skoring: generate penilaian otomatis dari data pelamar berdasarkan aturan
- Aturan skoring: mapping data pelamar (pengalaman, pendidikan, organisasi, berkas, profil) ke sub-kriteria
- Perhitungan SAW 3 langkah (Matriks X → Normalisasi R → Preferensi V)
- Hasil akhir ranking

### Role Atasan
- Dashboard statistik
- Lihat data pelamar + detail profil (LinkedIn-style)
- Lihat penilaian, perhitungan SAW, dan hasil akhir
- **Read-only**, tidak bisa mengubah data

### Role Pelamar
- Dashboard pribadi
- Edit profil (nama, email, telepon, alamat, jarak rumah, riwayat penyakit)
- Riwayat pengalaman kerja (CRUD)
- Riwayat pendidikan (CRUD)
- Riwayat organisasi (CRUD)
- Upload & preview berkas (PDF, gambar, dokumen)
- Lihat hasil rekomendasi diri sendiri

## Instalasi

### 1. Clone atau copy project

```bash
cd /Applications/MAMP/htdocs/
git clone <repo-url> anggi-spk-saw
```

### 2. Database

Import schema dan seed data:

```bash
/Applications/MAMP/Library/bin/mysql80/bin/mysql \
  -u root -proot -S /Applications/MAMP/tmp/mysql/mysql.sock \
  -e "DROP DATABASE IF EXISTS anggi_spk_saw; CREATE DATABASE anggi_spk_saw;"
/Applications/MAMP/Library/bin/mysql80/bin/mysql \
  -u root -proot -S /Applications/MAMP/tmp/mysql/mysql.sock \
  anggi_spk_saw < schema.sql
```

Atau jalankan semua query dari `schema.sql` manual melalui phpMyAdmin.

### 3. Konfigurasi Database

File: `application/config/database.php`

```php
'hostname' => '127.0.0.1:8889',  // MAMP = port 8889
'username' => 'root',
'password' => 'root',
'database' => 'anggi_spk_saw',
```

### 4. Base URL

File: `application/config/config.php`

```php
$config['base_url'] = 'http://localhost:8888/anggi-spk-saw/';
```

### 5. Uploads

Folder upload berkas pelamar. Pastikan writable:

```bash
mkdir -p uploads/berkas
chmod 755 uploads/berkas
```

## Akun Default

| Role | Username | Password |
|------|----------|----------|
| Admin (HRD) | `admin` | `password` |
| Atasan | `atasan` | `password` |
| Pelamar | `ahmad` | `password` |
| Pelamar | `siti` | `password` |
| Pelamar | `budi` | `password` |
| Pelamar | `dewi` | `password` |
| Pelamar | `rudi` | `password` |

## Alur Sistem

```
Pelamar Register → Isi Profil, Pengalaman, Pendidikan, Organisasi, Upload Berkas
       ↓
HRD Setup → Kriteria & Sub Kriteria, Bobot, Aturan Skoring
       ↓
HRD Auto-Skoring → Generate penilaian otomatis dari data pelamar
       ↓
HRD Review → Edit manual penilaian jika perlu
       ↓
SAW Calculation → Matriks X → Normalisasi R → Preferensi V
       ↓
Hasil Ranking → HRD & Atasan lihat hasil, Pelamar lihat posisi sendiri
```

## Metode SAW (Simple Additive Weighting)

### 1. Matriks Keputusan (X)

Membangun matriks X berisi nilai setiap alternatif (Aᵢ) pada setiap kriteria (Cⱼ):

```
     C₁  C₂  C₃  ...  Cₙ
A₁  [X₁₁ X₁₂ X₁₃  ...  X₁ₙ]
A₂  [X₂₁ X₂₂ X₂₃  ...  X₂ₙ]
A₃  [X₃₁ X₃₂ X₃₃  ...  X₃ₙ]
...  ...
Aₘ  [Xₘ₁ Xₘ₂ Xₘ₃  ...  Xₘₙ]
```

**Nilai Xᵢⱼ** diambil dari tabel `penilaian` yang berisi `id_sub` (merujuk ke `sub_kriteria.nilai`). Setiap alternatif memiliki tepat satu nilai per kriteria.

### 2. Normalisasi Matriks (R)

Menormalisasi setiap nilai berdasarkan jenis kriteria:

**Benefit** (semakin besar semakin baik):
```
Rᵢⱼ = Xᵢⱼ / max(Xⱼ)
```
Nilai dibagi dengan nilai **maksimum** dari semua alternatif pada kriteria tersebut.

**Cost** (semakin kecil semakin baik):
```
Rᵢⱼ = min(Xⱼ) / Xᵢⱼ
```
Nilai **minimum** dibagi dengan nilai alternatif pada kriteria tersebut.

**Contoh Normalisasi (C01 Masa Kerja — Benefit):**

| Alternatif | Nilai (X) | Normalisasi (R) |
|-----------|-----------|----------------|
| Ahmad | 5 | 5/5 = 1,0000 |
| Siti | 4 | 4/5 = 0,8000 |
| Budi | 4 | 4/5 = 0,8000 |
| Dewi | 3 | 3/5 = 0,6000 |
| Rudi | 2 | 2/5 = 0,4000 |
| **max** | **5** | |

**Contoh (C06 Jarak — Cost):**

| Alternatif | Nilai (X) | Normalisasi (R) |
|-----------|-----------|----------------|
| Dewi | 1 | 1/1 = 1,0000 |
| Ahmad | 2 | 1/2 = 0,5000 |
| Siti | 3 | 1/3 = 0,3333 |
| Budi | 4 | 1/4 = 0,2500 |
| Rudi | 5 | 1/5 = 0,2000 |
| **min** | **1** | |

### 3. Nilai Preferensi (V)

Menghitung total skor setiap alternatif dengan menjumlahkan hasil kali nilai R dengan bobot setiap kriteria:

```
Vᵢ = Σ(Rᵢⱼ × Wⱼ)  untuk j = 1..n
```

Dimana **Wⱼ** adalah bobot kriteria (dalam desimal, misal 25% = 0,25).

**Contoh perhitungan (Ahmad):**
```
V = (R_C01 × 0,20) + (R_C02 × 0,15) + (R_C03 × 0,25) + (R_C04 × 0,10) + (R_C05 × 0,10) + (R_C06 × 0,10) + (R_C07 × 0,10)
  = (1,0000 × 0,20) + (0,6000 × 0,15) + (0,8000 × 0,25) + (1,0000 × 0,10) + (0,8000 × 0,10) + (0,5000 × 0,10) + (1,0000 × 0,10)
  = 0,2000 + 0,0900 + 0,2000 + 0,1000 + 0,0800 + 0,0500 + 0,1000
  = 0,8200
```

### 4. Ranking

Semua alternatif diurutkan DESC berdasarkan nilai V. Alternatif dengan V tertinggi adalah rekomendasi utama.

## Auto-Skoring — Workflow

Auto-skoring adalah fitur untuk mengisi penilaian secara otomatis berdasarkan data yang diisi pelamar, tanpa HRD harus input manual satu per satu.

### Flow

```
HRD membuat Aturan Skoring
  ├─ Tentukan Kriteria (misal C01 = Masa Kerja)
  ├─ Tentukan Sub Kriteria (misal > 8 Tahun → nilai 5)
  ├─ Pilih Sumber Data (pengalaman_kerja, pendidikan, organisasi, berkas, profil)
  ├─ Pilih Field Sumber (total_tahun, jenjang, jumlah, jenis_berkas, jarak_rumah, dll)
  ├─ Tentukan Operator (>=, <=, =, >, <, between)
  └─ Tentukan Nilai (misal >= 8)
       ↓
HRD klik "Generate Semua Pelamar" di menu Auto Skoring
       ↓
Sistem loop setiap pelamar:
  1. Ambil semua aturan skoring
  2. Untuk setiap aturan, baca data dari tabel sumber:
     - pengalaman_kerja  → hitung total tahun (SUM tahun_selesai - tahun_mulai)
     - pendidikan        → ambil jenjang tertinggi
     - organisasi        → hitung jumlah organisasi
     - berkas            → cek jenis_berkas yang diupload
     - profil            → baca field langsung (jarak_rumah, riwayat_penyakit, dll)
  3. Evaluasi kondisi (operator + nilai) terhadap data
  4. Jika cocok → simpan penilaian (id_alternatif, id_kriteria, id_sub)
  5. Jika tidak ada aturan cocok → kriteria tersebut tidak diisi (kosong)
       ↓
HRD review & edit manual di halaman Penilaian
       ↓
SAW siap dihitung
```

### Contoh Aturan Skoring

| Kriteria | Sumber | Field | Operator | Nilai | Sub Kriteria |
|----------|--------|-------|----------|-------|-------------|
| C01 (Masa Kerja) | pengalaman_kerja | total_tahun | >= | 8 | > 8 Tahun (nilai 5) |
| C01 (Masa Kerja) | pengalaman_kerja | total_tahun | >= | 5 | 5-8 Tahun (nilai 4) |
| C01 (Masa Kerja) | pengalaman_kerja | total_tahun | >= | 3 | 3-5 Tahun (nilai 3) |
| C02 (Pendidikan) | pendidikan | jenjang | = | S1 | S1 (nilai 3) |
| C02 (Pendidikan) | pendidikan | jenjang | = | D3 | D3 (nilai 2) |
| C05 (Organisasi) | organisasi | jumlah | >= | 3 | 3 Organisasi (nilai 4) |
| C06 (Jarak) | profil | jarak_rumah | >= | 10 | 10-20 km (nilai 4) |
| C07 (Penyakit) | profil | riwayat_penyakit | = | Tidak | Tidak Ada (nilai 5) |

### Aturan Prioritas

Aturan dievaluasi dari **nilai threshold terbesar ke terkecil** per kriteria. Aturan pertama yang cocok digunakan (prioritas tinggi). Contoh untuk C01:

- `total_tahun >= 8` → cek pertama
- Jika tidak cocok → `total_tahun >= 5`
- Jika tidak cocok → `total_tahun >= 3`
- dst.

Ini memastikan pelamar dengan 6 tahun pengalaman mendapat sub `5-8 Tahun` (nilai 4), bukan `3-5 Tahun` (nilai 3).

## Struktur Database (10 Tabel)

| Tabel | Fungsi |
|-------|--------|
| `users` | Akun login (admin, atasan, pelamar) |
| `alternatif` | Data kandidat pelamar (profil, jarak, riwayat penyakit) |
| `kriteria` | Kriteria penilaian (C01–C07) |
| `sub_kriteria` | Opsi nilai per kriteria (1-5) |
| `penilaian` | Nilai setiap alternatif × kriteria |
| `pengalaman_kerja` | Riwayat kerja pelamar |
| `pendidikan` | Riwayat pendidikan pelamar |
| `organisasi` | Riwayat organisasi pelamar |
| `berkas` | File upload pelamar |
| `aturan_skoring` | Aturan auto-skoring data → sub_kriteria |

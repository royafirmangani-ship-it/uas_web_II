-- Database: db_sistem_klinik
-- Sistem Informasi Klinik
-- CodeIgniter 3 + AdminLTE + MySQL

CREATE DATABASE IF NOT EXISTS db_sistem_klinik;
USE db_sistem_klinik;

-- --------------------------------------------------------
-- Table: users
-- --------------------------------------------------------
CREATE TABLE users (
    id_user INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'petugas') NOT NULL DEFAULT 'petugas',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table: pasien
-- --------------------------------------------------------
CREATE TABLE pasien (
    id_pasien INT(11) AUTO_INCREMENT PRIMARY KEY,
    no_rm VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    tanggal_lahir DATE NOT NULL,
    alamat TEXT,
    telepon VARCHAR(20),
    foto VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table: dokter
-- --------------------------------------------------------
CREATE TABLE dokter (
    id_dokter INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    spesialis VARCHAR(100),
    telepon VARCHAR(20),
    alamat TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table: poli
-- --------------------------------------------------------
CREATE TABLE poli (
    id_poli INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama_poli VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table: obat
-- --------------------------------------------------------
CREATE TABLE obat (
    id_obat INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama_obat VARCHAR(100) NOT NULL,
    stok INT(11) NOT NULL DEFAULT 0,
    harga DECIMAL(10,2) NOT NULL DEFAULT 0,
    satuan VARCHAR(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table: pendaftaran
-- --------------------------------------------------------
CREATE TABLE pendaftaran (
    id_daftar INT(11) AUTO_INCREMENT PRIMARY KEY,
    id_pasien INT(11) NOT NULL,
    id_dokter INT(11) NOT NULL,
    id_poli INT(11) NOT NULL,
    tanggal DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    keluhan TEXT,
    status ENUM('menunggu', 'diperiksa', 'selesai') NOT NULL DEFAULT 'menunggu',
    FOREIGN KEY (id_pasien) REFERENCES pasien(id_pasien) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_dokter) REFERENCES dokter(id_dokter) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_poli) REFERENCES poli(id_poli) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table: pemeriksaan
-- --------------------------------------------------------
CREATE TABLE pemeriksaan (
    id_periksa INT(11) AUTO_INCREMENT PRIMARY KEY,
    id_daftar INT(11) NOT NULL UNIQUE,
    diagnosa TEXT,
    tindakan TEXT,
    berat_badan DECIMAL(5,2),
    tinggi_badan DECIMAL(5,2),
    tekanan_darah VARCHAR(20),
    catatan TEXT,
    tgl_periksa DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_daftar) REFERENCES pendaftaran(id_daftar) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table: resep
-- --------------------------------------------------------
CREATE TABLE resep (
    id_resep INT(11) AUTO_INCREMENT PRIMARY KEY,
    id_periksa INT(11) NOT NULL,
    tanggal DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_periksa) REFERENCES pemeriksaan(id_periksa) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table: detail_resep
-- --------------------------------------------------------
CREATE TABLE detail_resep (
    id_detail INT(11) AUTO_INCREMENT PRIMARY KEY,
    id_resep INT(11) NOT NULL,
    id_obat INT(11) NOT NULL,
    jumlah INT(11) NOT NULL DEFAULT 1,
    aturan_pakai VARCHAR(255),
    FOREIGN KEY (id_resep) REFERENCES resep(id_resep) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_obat) REFERENCES obat(id_obat) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table: pembayaran
-- --------------------------------------------------------
CREATE TABLE pembayaran (
    id_bayar INT(11) AUTO_INCREMENT PRIMARY KEY,
    id_periksa INT(11) NOT NULL UNIQUE,
    biaya DECIMAL(12,2) NOT NULL DEFAULT 0,
    status ENUM('lunas', 'belum', 'batal') NOT NULL DEFAULT 'belum',
    tanggal DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_periksa) REFERENCES pemeriksaan(id_periksa) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Indexes
-- --------------------------------------------------------
CREATE INDEX idx_pendaftaran_tanggal ON pendaftaran(tanggal);
CREATE INDEX idx_pembayaran_tanggal ON pembayaran(tanggal);
CREATE INDEX idx_pasien_no_rm ON pasien(no_rm);
CREATE INDEX idx_pasien_nama ON pasien(nama);

-- --------------------------------------------------------
-- Sample Data
-- --------------------------------------------------------

-- Password: admin123 (bcrypt)
INSERT INTO users (nama, username, password, role) VALUES
('Administrator', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Petugas Klinik', 'petugas', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'petugas');

INSERT INTO poli (nama_poli) VALUES
('Poli Umum'),
('Poli Gigi'),
('Poli Anak'),
('Poli Kandungan'),
('Poli Mata');

INSERT INTO dokter (nama, spesialis, telepon, alamat) VALUES
('Dr. Ahmad Syarif', 'Umum', '081234567890', 'Jl. Merdeka No. 1'),
('Dr. Siti Rahmawati', 'Gigi', '081234567891', 'Jl. Merdeka No. 2'),
('Dr. Budi Santoso', 'Anak', '081234567892', 'Jl. Merdeka No. 3');

INSERT INTO obat (nama_obat, stok, harga, satuan) VALUES
('Paracetamol 500mg', 100, 5000, 'strip'),
('Amoxicillin 500mg', 50, 15000, 'strip'),
('Ibuprofen 400mg', 75, 12000, 'strip'),
('Antasida DOEN', 200, 3000, 'tablet'),
('Vitamin C 100mg', 150, 2000, 'tablet');

INSERT INTO pasien (no_rm, nama, jenis_kelamin, tanggal_lahir, alamat, telepon) VALUES
('RM-20240001', 'Bambang Suprapto', 'L', '1990-05-15', 'Jl. Sudirman No. 10', '085612345678'),
('RM-20240002', 'Dewi Sartika', 'P', '1985-08-20', 'Jl. Gatot Subroto No. 5', '085612345679'),
('RM-20240003', 'Joko Widodo', 'L', '1975-01-10', 'Jl. Diponegoro No. 3', '085612345680');

INSERT INTO pendaftaran (id_pasien, id_dokter, id_poli, tanggal, keluhan, status) VALUES
(1, 1, 1, '2024-01-15 08:30:00', 'Demam dan batuk sejak 3 hari', 'selesai'),
(2, 2, 2, '2024-01-15 09:00:00', 'Sakit gigi berlubang', 'selesai'),
(3, 3, 3, '2024-01-15 10:00:00', 'Demam tinggi kejang', 'selesai');

INSERT INTO pemeriksaan (id_daftar, diagnosa, tindakan, berat_badan, tinggi_badan, tekanan_darah, catatan) VALUES
(1, 'ISPA (Infeksi Saluran Pernafasan Akut)', 'Diberikan obat penurun panas dan antibiotik', 65.00, 170.00, '120/80', 'Pasien disarankan istirahat'),
(2, 'Karies gigi', 'Penambalan gigi', 55.00, 160.00, '110/70', 'Kontrol 1 minggu lagi'),
(3, 'Demam Berdarah', 'Perawatan intensif', 30.00, 140.00, '100/60', 'Rawat inap');

INSERT INTO resep (id_periksa, tanggal) VALUES
(1, '2024-01-15 09:00:00'),
(2, '2024-01-15 09:30:00'),
(3, '2024-01-15 10:30:00');

INSERT INTO detail_resep (id_resep, id_obat, jumlah, aturan_pakai) VALUES
(1, 1, 1, '3x1 sehari setelah makan'),
(1, 2, 1, '3x1 sehari'),
(2, 3, 1, '2x1 sehari'),
(3, 1, 2, '3x1 sehari'),
(3, 5, 1, '1x1 sehari');

INSERT INTO pembayaran (id_periksa, biaya, status, tanggal) VALUES
(1, 150000, 'lunas', '2024-01-15 12:00:00'),
(2, 200000, 'lunas', '2024-01-15 12:30:00'),
(3, 500000, 'lunas', '2024-01-15 13:00:00');

-- =============================================
-- File SQL khoi tao database Manga Shop
-- Chay tren DB01 (virtualmachine2 - MySQL Server)
-- =============================================

CREATE DATABASE IF NOT EXISTS manga_shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE manga_shop;

-- Bang users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(100),
    email VARCHAR(100),
    role ENUM('admin', 'customer') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bang manga
CREATE TABLE manga (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    author VARCHAR(100),
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bang orders
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    status ENUM('pending','confirmed','shipped','done') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Bang order_items
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    manga_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (manga_id) REFERENCES manga(id)
);

-- Tai khoan mac dinh (mat khau PLACEHOLDER, phai chay setup_password.php de hash dung)
-- admin / Admin@2026
-- demo / Demo@2026
INSERT INTO users (username, password, fullname, email, role) VALUES
('admin', 'PLACEHOLDER', 'Quan tri vien', 'admin@nhom1.ictu.edu.vn', 'admin'),
('demo', 'PLACEHOLDER', 'Khach demo', 'demo@nhom1.ictu.edu.vn', 'customer');

-- Du lieu mau
INSERT INTO manga (title, author, description, price, stock, image) VALUES
('One Piece - Tap 1', 'Eiichiro Oda', 'Hanh trinh cua Luffy va bang Mu Rom bat dau tai Lang Fuusha. Mot cau chuyen phieu luu kinh dien.', 25000, 50, 'onepiece1.jpg'),
('Naruto - Tap 1', 'Masashi Kishimoto', 'Nin gia tre Naruto Uzumaki mo uoc tro thanh Hokage.', 23000, 40, 'naruto1.jpg'),
('Doraemon - Tap 1', 'Fujiko F. Fujio', 'Chu meo may den tu tuong lai va cau be Nobita.', 20000, 100, 'doraemon1.jpg'),
('Conan - Tap 1', 'Gosho Aoyama', 'Tham tu lung danh Conan - cau chuyen bat dau tu vu an tai cong vien giai tri.', 22000, 60, 'conan1.jpg'),
('Slam Dunk - Tap 1', 'Takehiko Inoue', 'Hanamichi Sakuragi va hanh trinh bong ro hoc duong.', 24000, 30, 'slamdunk1.jpg'),
('Dragon Ball - Tap 1', 'Akira Toriyama', 'Son Goku va hanh trinh tim 7 vien ngoc rong.', 25000, 45, 'dragonball1.jpg'),
('Attack on Titan - Tap 1', 'Hajime Isayama', 'Nhan loai chong lai nhung ten khong lo an thit nguoi.', 28000, 35, 'aot1.jpg'),
('Jujutsu Kaisen - Tap 1', 'Gege Akutami', 'Yuji Itadori va the gioi chu thuat.', 27000, 25, 'jjk1.jpg');

-- =============================================
-- Chay cac lenh duoi day voi quyen root tren MySQL
-- de tao user cho web va cap quyen tu xa
-- =============================================

-- Thay 192.168.1.10 bang IP cua DC01 (webserver)
-- Dung '%' thay cho IP neu muon cho phep tu bat ky IP nao (chi dung khi test)
CREATE USER IF NOT EXISTS 'webuser'@'192.168.1.10' IDENTIFIED BY 'Web@2026';
GRANT ALL PRIVILEGES ON manga_shop.* TO 'webuser'@'192.168.1.10';
FLUSH PRIVILEGES;

# Manga Shop - Nhom 1 ICTU

Website ban manga don gian - Mon Quan tri mang & Dien toan dam may.

## Kien truc 3 tang

- **DC01** (`192.168.1.10`): Domain Controller, DNS, DHCP, IIS + PHP (Web Server)
- **DB01** (`192.168.1.20`): MySQL Database Server
- **DEV01** (`192.168.1.30`): May code/client

## Yeu cau phan mem

### Tren DC01 (Web Server)
- Windows Server 2022
- IIS voi CGI
- VC_redist (Visual C++ Redistributable)
- PHP 8.x Non-Thread-Safe x64 (giai nen vao `C:\php`)
- Handler Mapping cho `*.php` qua FastCgiModule

### Tren DB01 (Database Server)
- Windows Server 2022
- MySQL Server 8.0
- MySQL Workbench (de thao tac giao dien)

### Tren DEV01 (Client/Developer)
- Windows Server 2022 hoac Windows 10/11 Pro
- VS Code
- Git (de dong bo code len DC01 qua GitHub)

## Huong dan cai dat

### Buoc 1: Tren DB01

1. Cai MySQL Server 8.0 va MySQL Workbench.
2. Mo MySQL Workbench, dang nhap voi quyen `root`.
3. Mo file `sql/manga_shop.sql`, chay toan bo noi dung.
4. Trong SQL script, **sua IP `192.168.1.10` thanh IP that cua DC01** truoc khi tao user webuser.
5. Dam bao MySQL lang nghe tren tat ca interface: sua `my.ini`, dong `bind-address = 0.0.0.0`.
6. Mo port 3306 trong Windows Firewall:
   ```
   netsh advfirewall firewall add rule name="MySQL" dir=in action=allow protocol=TCP localport=3306
   ```

### Buoc 2: Tren DC01

1. Cai IIS + CGI qua Server Manager.
2. Cai VC_redist (Visual C++ Redistributable).
3. Tai PHP 8.x NTS x64, giai nen vao `C:\php`.
4. Trong `C:\php\php.ini`, bat:
   ```
   extension=mysqli
   extension=pdo_mysql
   extension_dir = "ext"
   date.timezone = "Asia/Ho_Chi_Minh"
   ```
5. Trong IIS Manager:
   - Them Handler Mapping: `*.php` → `C:\php\php-cgi.exe` qua FastCgiModule.
   - Cap quyen cho `IIS_IUSRS`:
     ```
     icacls "C:\php" /grant "IIS_IUSRS":(OI)(CI)RX
     ```
6. Copy toan bo code vao `C:\inetpub\wwwroot\nhom1\`.
7. Trong `config.php`, sua `$DB_HOST = '192.168.1.20'` thanh IP that cua DB01.
8. Tao binding `www.nhom1.ictu.edu.vn` cho site trong IIS.
9. Trong DNS Manager, tao A record `www.nhom1.ictu.edu.vn` tro ve IP cua DC01.

### Buoc 3: Chay setup_password.php (mot lan)

Tu DEV01, mo trinh duyet, truy cap:
```
http://www.nhom1.ictu.edu.vn/setup_password.php
```

Sau khi thay thong bao OK, **XOA file setup_password.php tren DC01 ngay lap tuc**.

## Tai khoan mac dinh

- Admin: `admin` / `Admin@2026`
- Khach: `demo` / `Demo@2026`

## Cau truc thu muc

```
manga_shop/
├── config.php              Cau hinh ket noi DB
├── index.php               Trang chu
├── manga.php               Chi tiet manga
├── cart.php                Gio hang
├── checkout.php            Dat hang
├── login.php
├── register.php
├── logout.php
├── setup_password.php      Chay 1 lan de hash mat khau
├── admin/
│   ├── index.php
│   ├── manga_list.php
│   ├── manga_add.php
│   ├── manga_edit.php
│   ├── manga_delete.php
│   └── orders.php
├── includes/
│   ├── header.php
│   └── footer.php
├── css/
│   └── style.css
└── sql/
    └── manga_shop.sql      Chay tren DB01 de tao DB
```

## Chuc nang

### Khach hang
- Xem danh sach manga
- Xem chi tiet manga
- Them vao gio hang
- Thanh toan (tao order)
- Dang ky, dang nhap

### Admin
- CRUD manga (Create, Read, Update, Delete) - DAP UNG YEU CAU DE
- Xem danh sach don hang

## Luu y

- Code dung prepared statement de tranh SQL injection co ban.
- Mat khau duoc hash bang `password_hash` (bcrypt).
- Chua co upload anh - chi la ten file de minh hoa.
- Phien ban cho muc tieu demo chuc nang, chua toi uu bao mat day du.

## Thanh vien nhom 1

- Thanh vien 1: Infra Lead (DC01)
- Thanh vien 2: DB Lead (DB01)
- Thanh vien 3: Dev Lead (DEV01)

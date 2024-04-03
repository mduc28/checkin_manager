# Project Quản Lý Vào Ra

## Giới thiệu

Dự án Quản Lý check in là một hệ thống đơn giản được phát triển để quản lý việc check in của nhân viên và khách hàng trong một tổ chức. Dự án này cung cấp một giao diện dễ sử dụng để ghi nhận thời gian check in, theo dõi thống kê, và quản lý thông tin về nhân viên.

## Tính năng

- Ghi nhận thời gian check in của nhân viên và khách hàng.
- Quản lý thông tin về nhân viên và khách hàng.
- Hiển thị thống kê về thời gian check in.



# Hướng dẫn cài đặt

## Phiên bản yêu cầu

- **PHP version:** `8.2^`
- **Laravel version:** `10.x`
- **MySQL version:** `8.0.33`

## Hướng dẫn chi tiết

1. **Clone Repository:** Clone repository về htdocs của bạn nếu bạn dùng Xampp, về www nếu bạn dùng laragon.
2. **Cài đặt Dependencies:** Chạy câu lệnh `composer install` trong terminal tại thư mục chứa dự án.
3. **Cấu hình file env** Chạy câu lệnh `cp .env.example .env` để tạo file env.
    - **Cấu hình Cơ sở dữ liệu:** Cập nhật file env:
        +   `DB_CONNECTION=mysql`    
            `DB_HOST=127.0.0.1`            
            `DB_PORT=3306`                 
            `DB_DATABASE=check_in_manager`       
            `DB_USERNAME=root`             
            `DB_PASSWORD= `
    - **Generate key:** Chạy câu lệnh `php artisan key:generate` 
4. **Tạo bảng và dữ liệu mẫu:** 
    - Tạo một database mới với tên `check_in_manager` với collate `utf8mb4_unicode_ci` trong MySQL
    - Chạy câu lệnh `php artisan migrate` và `php artisan db:seed`
5. **Hướng dẫn chạy project:**
    - Khởi động `Apache`, `MySQL` trong `xampp` hoặc `laragon`.
    - Mở thư mục của dự án.
    - Chọn public để bắt đầu.
    - Tài khoản admin: `admin@expample.com`
    - Mật khẩu: `123456`.
    - Sau khi đăng nhập lần đầu cần thay mật khẩu để vào trang quản lý.

# Laravel Project

## Giới thiệu

Các bước dưới đây sẽ giúp bạn cài đặt và khởi chạy dự án.

## Mục lục

- [Giới thiệu](#giới-thiệu)
- [Cài đặt](#cài-đặt)
- [Chạy dự án](#chạy-dự-án)

## Cài đặt

### 1. Clone dự án từ Git

Clone dự án về máy và chuyển vào thư mục của dự án:

```bash
git clone https://gitlab.com/nguyenthanhvinh.jvb/auto-career-bridge
```

### 2. Cài đặt Composer Dependencies

```bash
composer i
```

### 2. Tạo file .env

```bash
cp .env.example .env
```

### 3. Tạo Application Key

```bash
php artisan key:generate
```

## Chạy dự án

### 1. Cấu hình env database

- Cấu hình DB_DATABASE
- Cấu hình DB_USERNAME
- Cấu hình DB_PASSWORD

### 2. Tạo dữ liệu mẫu

```bash
php artisan migrate:refresh --seed
```

### 3. Cài thư viện

```bash
composer i
```

### 4. Khởi chạy Server

```bash
php artisan ser
```

### 5. Chạy schedule

```bash
php artisan schedule:work
```

### 6. Chạy queue

```bash
php artisan queue:work
```

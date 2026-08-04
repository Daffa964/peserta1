# peserta1

Project ini menggunakan arsitektur containerized dengan Docker Compose dan terdiri dari tiga layanan utama:
- `nginx` sebagai reverse proxy / web server
- `php` sebagai runtime PHP-FPM
- `mariadb` sebagai database

## 1. Persyaratan
Sebelum menjalankan aplikasi, pastikan perangkat Anda sudah memiliki:
- Docker Engine
- Docker Compose
- Git

## 2. Langkah Instalasi
1. Clone repository:
   ```bash
   git clone <repo-url>
   cd peserta1
   ```
2. Pastikan struktur repo tersedia:
   - `docker-compose.yml`
   - `Dockerfile.php`
   - `Dockerfile.nginx`
   - `nginx/default.conf`
3. Buat atau sesuaikan file environment jika diperlukan.
4. Jalankan build dan deploy container:
   ```bash
   docker compose build nginx php
   docker compose up -d
   ```

## 3. Command Penting
Berikut command yang sering dipakai selama pengembangan dan deployment:

```bash
# build semua service
docker compose build

# jalankan service di background
docker compose up -d

# lihat status container
docker compose ps

# lihat log nginx
docker compose logs -f nginx

# lihat log php
docker compose logs -f php

# lihat log database
docker compose logs -f db

# stop service
docker compose down
```

## 4. Cara Menjalankan Aplikasi
Setelah container selesai dibangun, jalankan:

```bash
docker compose up -d
```

Aplikasi akan tersedia melalui port:
- `http://localhost` untuk akses web
- `localhost:80` diarahkan ke NGINX
- `php-fpm` berjalan di internal network container pada port `9000`

## 5. Struktur Container

### Service `nginx`
- Build dari `Dockerfile.nginx`
- Menggunakan konfigurasi `nginx/default.conf`
- Meneruskan request ke layanan PHP

### Service `php`
- Build dari `Dockerfile.php`
- Menjalankan PHP-FPM versi `8.3`
- Menggunakan directory `/var/www/html`

### Service `db`
- Menggunakan image `mariadb:latest`
- Menyimpan data persist pada volume `db-data`

## 6. Hasil Pengujian
Pengujian dilakukan pada konfigurasi deployment dan build workflow:
- Validasi file workflow GitHub Actions berhasil tanpa error syntax.
- Root cause error pada build Docker sebelumnya adalah path `backend/` yang tidak ada pada checkout repo.
- Setelah diperbaiki, konfigurasi build mengarah ke root repository (`COPY . /var/www/html/`) dan workflow menggunakan tag image yang valid.
- Pada environment lokal saat ini, `docker` CLI tidak tersedia sehingga pengujian runtime container belum bisa dijalankan langsung dari terminal ini.

## 7. Catatan
Jika repository Anda nanti memiliki aplikasi PHP lengkap (misalnya `composer.json`, `artisan`, atau file web app), maka proses build dan deployment akan otomatis memanfaatkan konfigurasi yang sudah dibuat.


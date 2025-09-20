# Project Name: Laravel POS

## Table of Contents

* [Introduction](#introduction)
* [Architecture](#architecture)
* [Features](#features)
* [Installation](#installation)
* [Development](#development)
* [Testing](#testing)

## Introduction

Laravel POS is a simple Point of Sale (POS) application built using Laravel. This application allows users to manage products, customers, orders, and sales reports.

## Architecture

The application is built using the Laravel framework. It uses a MySQL database for storing data. The application is divided into several layers, including the presentation layer, business logic layer, data access layer, and infrastructure layer.

## Features

* Manage products
* Manage customers
* Manage orders
* Generate sales reports
* API to mobile

## Installation

1. **Extract File Zip**
    - Download file zip dari sumber yang disediakan.
    - Extract file zip ke dalam direktori proyek Anda.

2. **Buka File Zip dengan Text Editor**
    - Gunakan text editor pilihan Anda (contoh: VSCode, Sublime Text, atau Notepad++).
    - Buka direktori proyek yang telah di extract.

3. **Siapkan Database**
    - Buat database baru di server database Anda (contoh: MySQL, PostgreSQL, atau SQLite).

4. **Jalankan `cp .env.example .env`, lalu Masukkan Konfigurasi Database**
    - Salin file `.env.example` menjadi `.env`.
    - Buka file `.env` dan masukkan informasi konfigurasi database Anda.

5. **Jalankan `composer update`**
    - Jalankan perintah `composer update` untuk menginstal semua dependensi yang diperlukan.

6. **Jalankan `php artisan key:generate`**
    - Jalankan perintah `php artisan key:generate` untuk menghasilkan kunci aplikasi.

7. **Jalankan `php artisan migrate`**
    - Jalankan perintah `php artisan migrate` untuk membuat tabel-tabel di database.

8. **Jalankan `php artisan make:filament-user`, lalu Masukkan Informasi User**
    - Jalankan perintah `php artisan make:filament-user` dan masukkan informasi pengguna yang diminta.
    ```
        Name:
        ❯ Super Admin

        Email address:
        ❯ admin@mahdev.com

        Password:
        ❯qwerty123
    ```
    -`INFO`
    - Success! admin@mahdev.com may now log in at http://localhost/admin/login.

9. **Jalankan `php artisan serve`, Buka Web di URL `/admin`**
    - Jalankan perintah `php artisan serve`.
    - Buka browser dan akses `http://localhost:8000/admin`.

10. **Project Siap Digunakan**
    - Proyek Laravel Anda sekarang siap digunakan.

Project siap digunakan

## Development

To contribute to the development of the application, follow these steps:

1. Clone the repository from GitHub.
2. Run the command `composer install` to install the dependencies.
3. Run the command `php artisan migrate` to migrate the database.
4. Make changes to the code.
5. Run the command `php artisan db:seed` to seed the database with sample data.
6. Commit changes to the repository.

## Testing

**Jalankan `php artisan serve`, Buka Web di URL `/admin`**
    - Jalankan perintah `php artisan serve`.
    - Buka browser dan akses `http://localhost:8000/admin`.

# Deadline-Tubes
> Penerapan String Matching dan Regular Expression dalam
Pembangunan Deadline Reminder Assistant “Deadline Chatbot”

## Table of contents
* [General info](#general-info)
* [Screenshots](#screenshots)
* [Technologies](#technologies)
* [Setup](#setup)
* [Features](#features)
* [Status](#status)
* [Inspiration](#inspiration)
* [Contact](#contact)

## General info
Dalam tugas besar ini, Anda akan diminta untuk membangun sebuah chatbot sederhana yang berfungsi untuk membantu mengingat berbagai deadline, tanggal penting, dan task-task tertentu kepada user yang menggunakannya. Dengan memanfaatkan algoritma String Matching dan Regular Expression, Anda dapat membangun sebuah chatbot interaktif sederhana layaknya Google Assistant yang akan menjawab segala pertanyaan Anda terkait informasi deadline tugas-tugas yang ada.

## Screenshots
![1](https://user-images.githubusercontent.com/49779495/116437438-a6538c80-a877-11eb-9ecc-3a89551ac920.jpg)
![2](https://user-images.githubusercontent.com/49779495/116437454-a9e71380-a877-11eb-8f29-d6957468eb76.jpg)
![3](https://user-images.githubusercontent.com/49779495/116437465-ace20400-a877-11eb-9944-86baf28b7b65.jpg)

## Technologies
* PHP
* Javascript
* Mysql
* HTML
* CSS

## Setup
1. Installasi XAMPP
2. Aktifkan Apache dan MySQL
3. Clone github https://github.com/tararahuuw/Deadline-Tubes pada directory htdocs
4. Sesuaikan username dan password MySql Anda menjadi username = "root" dan password = ""
5. Setup database pada localhost/Deadline-Tubes/src/src/database.php , jika terdapat pesan `Database created successfullyTabel dropped successfullyTabel created successfully` maka berhasil
6. Buka browser localhost/Deadline-Tubes/src/index.php

## Features
* List of features ready and TODOs for future development
* Menambah task baru
* Menampilkan daftar task
* Menampilkan deadline suatu task
* Memperbarui deadline suatu task
* Menandai task sudah selesai
* Menampilkan apa saja yang bisa dilakukan chat bot
* Menampilkan kalimat-kalimat yang tidak dikenali
* Memberikan sugesti pada typo kata-kata yang dianggap penting

## Status
Project is: _finished_

## Inspiration
https://informatika.stei.itb.ac.id/~rinaldi.munir/Stmik/2020-2021/Tugas-Besar-3-IF2211-Strategi-Algoritma-2021.pdf

## Contact
Created by Muhammad Fahmi Alamsyah - feel free to contact me!
Created by Widya Anugrah Putra - feel free to contact me!
Created by M. Jafar Gundari - feel free to contact me!

## Kata kunci perintah

### Kumpulan kata kunci
- kata kunci task ('kuis', 'tubes', 'tucil', 'ujian', 'praktikum', 'tugas', 'pr')
- Kata kunci addtask ('pada tanggal', 'pada', kata kunci task, kode kuliah (WWDDDD) dengan W huruf dan D angka, tanggal yang belum dilalui)
- kata kunci hapus task ('sudah selesai', 'beres', 'hapus')
- Kata kunci tampilkan task ('apa saja', 'tampilkan', 'daftar')
- Kata kunci time period ('sejauh ini', 'sampai saat ini', 'minggu ke depan', 'hari ke depan', 'hari ini', 'antara', 'semua')
- kata kunci perbarui task ('diundur', 'jadwal ulang', 'perbarui')
- kata kunci spesifik task ('kapan', 'deadline')
- kata kunci help ('bisa lakukan apa', 'bisa ngapain')

### Add task
- Mengandung kata kunci task ('kuis', 'tubes', 'tucil', 'ujian', 'praktikum', 'tugas', 'pr')
- Mengandung kode kuliah yang valid (2 huruf dan 4 angka)
- Mengandung tanggal yang valid sebagai deadline yang didahului kata "pada"
- Meletakkan topik tugas di antara kode kuliah dan kata "pada" sebelum tanggal deadline
- Contoh `Halo bot tolong tambahin pr IF2311 membajak sawah pada 23 mei 2021`

### Hapus task
- Mengandung kata kunci  'sudah selesai', 'beres', 'hapus',
- Mengandung kata kunci 'task' diikuti nomor ID
- Contoh `Halo bot, saya sudah selesai mengerjakan task 5`
- `Hapus task 10`

### Tampilkan task
- Mengandung kata kunci 'apa saja', 'tampilkan', 'daftar'
- Mengandung kata 'deadline'
- Mengandung kata bersifat time period berikut : 'sejauh ini', 'sampai saat ini', 'minggu ke depan', 'hari ke depan', 'hari ini', 'antara', 'semua'
- Opsional, mengandung keyword tugas tertentu antara lain : 'kuis', 'tubes', 'tucil', 'ujian', 'praktikum', 'tugas', 'pr'
- Jika menggunakan 'antara' harus mengandung 2 format tanggal masukan YYYY-MM-DD atau YYYY/MM/DD
- Jika mengandung N 'minggu ke depan' atau N 'hari ke depan' terdapat jumlah hari atau jumlah minggu sebelum kata tersebut.
- Contoh : `Halo bot apa saja deadline 5 minggu ke depan ?`
- `Halo bot tampilkan deadline sejauh ini`
- `Halo bot daftar deadline kuis antara 2021-03-20 sampai 2021-04-30`

### Perbarui task
- Mengandung kata kunci 'diundur', 'jadwal ulang', 'perbarui'
- Mengandung kata 'deadline'
- Mengandung 1 format tanggal YYYY-MM-DD atau YYYY/MM/DD yaitu tanggal baru dari suatu tugas
- Mengandung kata 'task X' dengan X adalah nomor id task pada database, tanggal baru harus lebih besar dari tanggal hari ini
- Contoh `Halo bot deadline task 3 dijadwal ulang menjadi 2021-04-30`
- `Perbarui deadline task 3 menjadi 2021-05-01`
- `Deadline task 3 diundur jadi 2021-05-02`

### Lihat deadline suatu task
- Mengandung kata kunci 'kapan' atau 'deadline'
- Mengandung kata kunci salah satu berikut : 'kuis', 'tubes', 'tucil', 'ujian', 'praktikum', 'tugas', 'pr'
- Mengandung nama mata kuliah
- Contoh `Halo bot deadline tubes IF2230 kapan ?`

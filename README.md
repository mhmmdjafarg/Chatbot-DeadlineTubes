# Deadline-Tubes



## Kata kunci perintah
### Kumpulan kata kunci
- kata kunci task ('kuis', 'tubes', 'tucil', 'ujian', 'praktikum', 'tugas', 'pr')
- Kata kunci addtask ()
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
- Jika mengandung 'minggu ke depan' atau 'hari ke depan' terdapat Nomor ID sebelum kata tersebut.
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
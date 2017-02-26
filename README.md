# Deksripsi Projek #

Projek ini di ikut sertakan dalam lomba BAF 2017.

### Fitur ###

* Configurasi ada di class/core.class.php
* Dump SQL .sql
* SMS Center dengan API dari Zenziva
* 3 Role Account (Administrator,Guru, dan Siswa)
* Role Admin : Register (Kelas,Siswa dan Guru), Register Administrator, Catatan Sistem, Restore dan Backup DB, Verifikasi (P. Broadcast Soal, P. Reset Jawaban)
* Role Guru  : Tambah/Hapus/Edit (Pengumuman,Bank Soal dan Register Ujian), Request (P.Reset Jawaban, P.Broadcast Soal)
* Role Siswa : Edit Data Profil, Pengerjaan Soal, Melihat Nilai, Melihat Daftar Ujian.
* BOT Telegram, di eksekusi dengan metode long polling, Command bisa di lihat dengan mengetikan /help di BOT
* Pengaturan SMS Settings berisi user + pass API Zenziva maka dari itu terlebih dahulu daftar akun zenziva.
* Untuk merubah format SMS bisa dilakukan di \pages\adminhome.php line 212 (Untuk Broadcast Soal)
* Analisis Soal Bagi Guru
* Lihat nilai Instant
# 🚀 Cara Menggunakan ngrok untuk HTTPS

## ✅ **Status: ngrok sudah terinstall!**

---

## 📋 **Langkah-langkah:**

### **1. Restart Terminal/PowerShell**

Karena PATH environment variable baru di-update, **restart terminal/PowerShell** Anda:
- Tutup terminal saat ini
- Buka terminal/PowerShell baru
- Atau refresh PATH dengan: `refreshenv` (jika menggunakan Chocolatey)

---

### **2. Setup Auth Token (PENTING!)**

Sebelum bisa menggunakan ngrok, Anda perlu:
1. **Daftar di ngrok:**
   - Kunjungi: https://dashboard.ngrok.com/signup
   - Buat akun gratis

2. **Dapatkan Auth Token:**
   - Login ke dashboard: https://dashboard.ngrok.com/get-started/your-authtoken
   - Copy auth token Anda

3. **Setup auth token di terminal:**
   ```bash
   ngrok config add-authtoken YOUR_AUTH_TOKEN
   ```
   Ganti `YOUR_AUTH_TOKEN` dengan token yang Anda copy dari dashboard.

---

### **3. Jalankan Laravel Server**

Di terminal pertama, jalankan:
```bash
php artisan serve
```

Server akan berjalan di: `http://localhost:8000`

---

### **4. Jalankan ngrok**

Di terminal baru (atau terminal kedua), jalankan:
```bash
ngrok http 8000
```

**Output yang akan muncul:**
```
ngrok                                                                              
                                                                                   
Session Status                online                                               
Account                       Your Email (Plan: Free)                              
Version                       3.x.x                                                
Region                        United States (us)                                   
Latency                       -                                                    
Web Interface                 http://127.0.0.1:4040                                
Forwarding                    https://abc123.ngrok-free.app -> http://localhost:8000
                                                                                   
Connections                   ttl     opn     rt1     rt5     p50     p90          
                              0       0       0.00    0.00    0.00    0.00         
```

---

### **5. Copy URL HTTPS**

Dari output ngrok, copy URL di bagian **"Forwarding"**:
```
https://abc123.ngrok-free.app
```

**Ini adalah URL HTTPS Anda!** 🎉

---

## 🔗 **Link-Link Penting:**

Setelah mendapatkan URL HTTPS (contoh: `https://abc123.ngrok-free.app`):

### **Dashboard Admin:**
```
https://abc123.ngrok-free.app/admin/dashboard
```

### **Login:**
```
https://abc123.ngrok-free.app/login
```

### **Register:**
```
https://abc123.ngrok-free.app/register
```

### **Homepage:**
```
https://abc123.ngrok-free.app
```

### **Debug Admin:**
```
https://abc123.ngrok-free.app/debug-admin
```

---

## ⚠️ **Catatan Penting:**

1. **URL ngrok berubah setiap restart** (kecuali pakai plan berbayar)
   - Setiap kali restart ngrok, URL akan berbeda
   - Copy URL baru setiap kali

2. **ngrok Web Interface:**
   - Akses: http://127.0.0.1:4040
   - Bisa melihat request/response di sini

3. **ngrok Free Plan:**
   - URL berubah setiap restart
   - Ada banner "Visit Site" (bisa di-skip)
   - Cocok untuk development/testing

---

## 🎯 **Quick Start Script:**

Atau gunakan script yang sudah dibuat:
```bash
# Jalankan script untuk mendapatkan URL HTTPS
.\get-https-url.bat
```

Script ini akan:
1. Cek apakah Laravel server berjalan
2. Start Laravel server jika belum berjalan
3. Start ngrok tunnel
4. Tampilkan URL HTTPS

---

## 🔧 **Troubleshooting:**

### **Problem: "ngrok: command not found"**
**Solusi:**
- Restart terminal/PowerShell
- Atau refresh PATH: `refreshenv` (jika pakai Chocolatey)

### **Problem: "ERR_NGROK_108" atau "authtoken required"**
**Solusi:**
- Setup auth token: `ngrok config add-authtoken YOUR_TOKEN`
- Dapatkan token dari: https://dashboard.ngrok.com/get-started/your-authtoken

### **Problem: "port 8000 already in use"**
**Solusi:**
- Stop Laravel server yang sedang berjalan (Ctrl+C)
- Atau gunakan port lain: `php artisan serve --port=8001`
- Lalu jalankan: `ngrok http 8001`

---

## ✅ **Verifikasi:**

Setelah setup, akses URL HTTPS di browser:
- ✅ Browser harus menampilkan 🔒 (lock icon)
- ✅ URL harus dimulai dengan `https://`
- ✅ Website Laravel Anda harus bisa diakses

---

**Selamat! Website Anda sekarang bisa diakses via HTTPS!** 🎉







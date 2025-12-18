# 🔧 Fix: ngrok Tidak Ditemukan

## ❌ **Masalah:**
```
ngrok : The term 'ngrok' is not recognized...
```

---

## ✅ **Solusi:**

### **Opsi 1: Install Manual (RECOMMENDED)** ⭐

Jalankan script yang sudah dibuat:

```powershell
.\install-ngrok-manual.ps1
```

Script ini akan:
1. Download ngrok dari website resmi
2. Extract ke folder `%USERPROFILE%\ngrok`
3. Menambahkan ke PATH
4. Memberikan instruksi selanjutnya

**Setelah script selesai, RESTART terminal!**

---

### **Opsi 2: Download Manual**

1. **Download ngrok:**
   - Kunjungi: https://ngrok.com/download
   - Pilih "Windows" → Download ZIP

2. **Extract:**
   - Extract ke folder: `C:\Users\abhia\ngrok` (atau folder lain)

3. **Tambahkan ke PATH:**
   - Tekan `Win + R` → ketik `sysdm.cpl` → Enter
   - Tab "Advanced" → "Environment Variables"
   - Di "User variables", pilih "Path" → "Edit"
   - "New" → Tambahkan: `C:\Users\abhia\ngrok`
   - OK semua

4. **Restart terminal**

5. **Test:**
   ```bash
   ngrok version
   ```

---

### **Opsi 3: Install via Chocolatey**

Jika Anda punya Chocolatey:

```powershell
choco install ngrok
```

---

### **Opsi 4: Gunakan Full Path**

Jika ngrok sudah terinstall tapi tidak di PATH:

```powershell
# Cari lokasi ngrok
Get-ChildItem -Path "$env:USERPROFILE" -Recurse -Filter "ngrok.exe" -ErrorAction SilentlyContinue

# Atau cek di lokasi umum
Test-Path "$env:LOCALAPPDATA\Microsoft\WinGet\Packages\*\ngrok.exe"
```

Lalu gunakan full path:
```powershell
& "C:\path\to\ngrok.exe" version
```

---

## 🚀 **Setelah ngrok Terinstall:**

### **1. Restart Terminal**
Tutup dan buka terminal baru.

### **2. Verifikasi:**
```bash
ngrok version
```

### **3. Setup Auth Token:**
```bash
ngrok config add-authtoken YOUR_AUTH_TOKEN
```
Dapatkan token dari: https://dashboard.ngrok.com/get-started/your-authtoken

### **4. Jalankan ngrok:**
```bash
# Terminal 1: Laravel
php artisan serve

# Terminal 2: ngrok
ngrok http 8000
```

---

## 📋 **Quick Fix:**

```powershell
# Jalankan script install
.\install-ngrok-manual.ps1

# Restart terminal

# Test
ngrok version
```

---

## ✅ **Verifikasi:**

Setelah install dan restart terminal:
```bash
ngrok version
```

**Harus menampilkan:**
```
ngrok version 3.x.x
```

---

**Jalankan `.\install-ngrok-manual.ps1` untuk install ngrok secara manual!** 🚀







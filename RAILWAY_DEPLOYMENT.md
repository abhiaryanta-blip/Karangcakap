# 🚀 Railway Deployment Guide

## Cara Deploy ke Railway (Step by Step)

### **1. Login ke Railway**
- Buka: https://railway.app
- Klik "Login with GitHub"
- Authorize Railway untuk akses GitHub

### **2. Create New Project**
- Klik "New Project"
- Pilih "Deploy from GitHub repo"
- Cari repository: `Karangcakap`
- Klik "Deploy"

### **3. Railway akan auto-detect Dockerfile**
✅ Dockerfile sudah ada di repository
✅ Railway akan build image secara otomatis
✅ Tunggu deployment 2-5 menit

### **4. Set Environment Variables (Optional)**
Jika ingin customize:
1. Buka Railway dashboard
2. Klik "Variables"
3. Tambahkan atau override:
   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://[domain-railway-Anda].railway.app
   ```

### **5. Generate Public Domain**
1. Di Railway dashboard, buka "Settings"
2. Cari "Networking" atau "Public Networking"
3. Aktifkan custom domain (opsional)
4. Railway akan auto-assign domain gratis

### **6. Check Deployment Status**
- Jika ✅ "Success" → Website sudah live!
- Jika ❌ "Failed" → Lihat logs untuk debug

## Jika Deployment Gagal

### **Check Logs di Railway**
1. Buka Railway dashboard
2. Tab "Logs"
3. Lihat error message
4. Common errors:
   - `Database locked` → Fix: Dockerfile sudah handle
   - `Permission denied` → Fix: chmod sudah di Dockerfile
   - `Out of memory` → Fix: Upgrade Railway plan

### **Troubleshooting**
- Pastikan `.env.production` ada di repo ✅
- Pastikan `composer.lock` ada di repo ✅
- Database SQLite akan auto-create di container ✅
- Storage folders permissions sudah fixed ✅

## After Deployment

### **Website URL**
- Railway akan assign domain otomatis
- Format: `https://[project-name]-[random].railway.app`
- Contoh: `https://karangcakap-production-abc123.railway.app`

### **Test Website**
1. Buka domain Railway
2. Harus muncul halaman Karang Cakap
3. Test fitur: Berita, Chat, Login

### **Monitor Performance**
- Railway dashboard menunjukkan:
  - CPU usage
  - Memory usage
  - Network traffic
  - Uptime

## Cost & Limits

**Railway Free Plan:**
- 5 GB per month data transfer
- 512 MB RAM
- Cukup untuk development/demo

**Upgrade ke paid jika:**
- Traffic tinggi
- Need more storage
- Need database production-grade

---

**Siap deploy? Go to: https://railway.app** 🚀

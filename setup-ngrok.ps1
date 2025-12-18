# PowerShell script untuk setup ngrok

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Setup ngrok untuk HTTPS Development" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Check if ngrok is installed
$ngrokInstalled = Get-Command ngrok -ErrorAction SilentlyContinue

if (-not $ngrokInstalled) {
    Write-Host "[INFO] ngrok tidak ditemukan. Menginstall..." -ForegroundColor Yellow
    Write-Host ""
    Write-Host "Pilih metode instalasi:" -ForegroundColor Yellow
    Write-Host "1. Via winget (Recommended)"
    Write-Host "2. Download manual dari https://ngrok.com/download"
    Write-Host ""
    $choice = Read-Host "Pilih (1 atau 2)"
    
    if ($choice -eq "1") {
        Write-Host "[INFO] Installing ngrok via winget..." -ForegroundColor Yellow
        winget install ngrok.ngrok
        if ($LASTEXITCODE -ne 0) {
            Write-Host "[ERROR] Gagal install ngrok via winget" -ForegroundColor Red
            Write-Host "[INFO] Silakan download manual dari https://ngrok.com/download" -ForegroundColor Yellow
            exit 1
        }
    } else {
        Write-Host "[INFO] Silakan download dan install ngrok dari:" -ForegroundColor Yellow
        Write-Host "       https://ngrok.com/download" -ForegroundColor Cyan
        Write-Host ""
        Write-Host "Setelah install, jalankan script ini lagi." -ForegroundColor Yellow
        exit 0
    }
}

Write-Host ""
Write-Host "[SUCCESS] ngrok sudah terinstall!" -ForegroundColor Green
Write-Host ""

# Check if auth token is configured
$ngrokConfig = "$env:USERPROFILE\.ngrok2\ngrok.yml"
if (-not (Test-Path $ngrokConfig)) {
    Write-Host "[INFO] ngrok belum dikonfigurasi." -ForegroundColor Yellow
    Write-Host ""
    Write-Host "Untuk mendapatkan auth token:" -ForegroundColor Yellow
    Write-Host "1. Daftar di: https://dashboard.ngrok.com/signup" -ForegroundColor Cyan
    Write-Host "2. Login dan copy auth token dari dashboard" -ForegroundColor Cyan
    Write-Host ""
    $authToken = Read-Host "Masukkan auth token Anda"
    
    if ($authToken) {
        Write-Host "[INFO] Setting up auth token..." -ForegroundColor Yellow
        ngrok config add-authtoken $authToken
        Write-Host "[SUCCESS] Auth token berhasil di-setup!" -ForegroundColor Green
    } else {
        Write-Host "[ERROR] Auth token tidak boleh kosong!" -ForegroundColor Red
        exit 1
    }
} else {
    Write-Host "[SUCCESS] ngrok sudah dikonfigurasi!" -ForegroundColor Green
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Setup selesai!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Untuk menjalankan ngrok:" -ForegroundColor Yellow
Write-Host "  1. Jalankan Laravel server: php artisan serve" -ForegroundColor Cyan
Write-Host "  2. Di terminal baru, jalankan: ngrok http 8000" -ForegroundColor Cyan
Write-Host "  3. Copy URL HTTPS dari output ngrok" -ForegroundColor Cyan
Write-Host ""
Write-Host "Atau jalankan: .\start-https-ngrok.bat" -ForegroundColor Cyan
Write-Host ""







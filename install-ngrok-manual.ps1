# Script untuk download dan install ngrok secara manual

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Install ngrok Manual" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Buat folder untuk ngrok
$ngrokDir = "$env:USERPROFILE\ngrok"
if (-not (Test-Path $ngrokDir)) {
    New-Item -ItemType Directory -Path $ngrokDir | Out-Null
    Write-Host "[INFO] Membuat folder: $ngrokDir" -ForegroundColor Yellow
}

# Download ngrok
Write-Host "[INFO] Downloading ngrok..." -ForegroundColor Yellow
$ngrokUrl = "https://bin.equinox.io/c/bNyj1mQVY4c/ngrok-v3-stable-windows-amd64.zip"
$zipPath = "$ngrokDir\ngrok.zip"

try {
    Invoke-WebRequest -Uri $ngrokUrl -OutFile $zipPath -UseBasicParsing
    Write-Host "[SUCCESS] Download selesai!" -ForegroundColor Green
} catch {
    Write-Host "[ERROR] Gagal download ngrok: $_" -ForegroundColor Red
    Write-Host ""
    Write-Host "Alternatif: Download manual dari:" -ForegroundColor Yellow
    Write-Host "  https://ngrok.com/download" -ForegroundColor Cyan
    exit 1
}

# Extract ngrok
Write-Host "[INFO] Extracting ngrok..." -ForegroundColor Yellow
try {
    Expand-Archive -Path $zipPath -DestinationPath $ngrokDir -Force
    Remove-Item $zipPath -Force
    Write-Host "[SUCCESS] Extract selesai!" -ForegroundColor Green
} catch {
    Write-Host "[ERROR] Gagal extract: $_" -ForegroundColor Red
    exit 1
}

# Tambahkan ke PATH (User)
$ngrokExe = "$ngrokDir\ngrok.exe"
if (Test-Path $ngrokExe) {
    Write-Host "[INFO] Menambahkan ngrok ke PATH..." -ForegroundColor Yellow
    
    $currentPath = [Environment]::GetEnvironmentVariable("Path", "User")
    if ($currentPath -notlike "*$ngrokDir*") {
        [Environment]::SetEnvironmentVariable("Path", "$currentPath;$ngrokDir", "User")
        Write-Host "[SUCCESS] ngrok ditambahkan ke PATH!" -ForegroundColor Green
    } else {
        Write-Host "[INFO] ngrok sudah ada di PATH" -ForegroundColor Yellow
    }
    
    Write-Host ""
    Write-Host "========================================" -ForegroundColor Cyan
    Write-Host "  Install selesai!" -ForegroundColor Green
    Write-Host "========================================" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "Lokasi ngrok: $ngrokExe" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "PENTING: Restart terminal/PowerShell untuk menggunakan ngrok!" -ForegroundColor Yellow
    Write-Host ""
    Write-Host "Setelah restart, jalankan:" -ForegroundColor Yellow
    Write-Host "  ngrok version" -ForegroundColor Cyan
    Write-Host "  ngrok config add-authtoken YOUR_TOKEN" -ForegroundColor Cyan
    Write-Host "  ngrok http 8000" -ForegroundColor Cyan
    Write-Host ""
} else {
    Write-Host "[ERROR] ngrok.exe tidak ditemukan setelah extract!" -ForegroundColor Red
    exit 1
}







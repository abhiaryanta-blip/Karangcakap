@echo off
echo ========================================
echo   Starting Laravel with HTTPS (ngrok)
echo ========================================
echo.

REM Check if ngrok is installed
where ngrok >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] ngrok tidak ditemukan!
    echo.
    echo Silakan install ngrok terlebih dahulu:
    echo   1. Download dari: https://ngrok.com/download
    echo   2. Atau install via: winget install ngrok.ngrok
    echo   3. Setup auth token: ngrok config add-authtoken YOUR_TOKEN
    echo.
    pause
    exit /b 1
)

REM Check if Laravel server is running
netstat -an | find "8000" >nul 2>nul
if %ERRORLEVEL% EQU 0 (
    echo [INFO] Laravel server sudah berjalan di port 8000
) else (
    echo [INFO] Starting Laravel server...
    start "Laravel Server" cmd /k "php artisan serve"
    timeout /t 3 /nobreak >nul
)

echo.
echo [INFO] Starting ngrok tunnel...
echo [INFO] URL HTTPS akan muncul di bawah ini:
echo.
echo ========================================
echo   Copy URL HTTPS dari output ngrok
echo   (Format: https://xxxxx.ngrok-free.app)
echo ========================================
echo.

REM Start ngrok
ngrok http 8000

pause





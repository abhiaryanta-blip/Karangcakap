@echo off
echo ========================================
echo   Get HTTPS URL dengan ngrok
echo ========================================
echo.

REM Check if Laravel server is running
netstat -an | find "8000" >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo [WARNING] Laravel server tidak berjalan di port 8000
    echo [INFO] Starting Laravel server...
    start "Laravel Server" cmd /k "php artisan serve"
    timeout /t 5 /nobreak >nul
    echo [SUCCESS] Laravel server started!
    echo.
)

echo [INFO] Starting ngrok tunnel...
echo.
echo ========================================
echo   URL HTTPS Anda akan muncul di bawah:
echo ========================================
echo.
echo [CONTOH OUTPUT:]
echo   Forwarding   https://abc123.ngrok-free.app -^> http://localhost:8000
echo.
echo [LINK PENTING:]
echo   - Dashboard Admin: https://xxxxx.ngrok-free.app/admin/dashboard
echo   - Login: https://xxxxx.ngrok-free.app/login
echo   - Homepage: https://xxxxx.ngrok-free.app
echo.
echo ========================================
echo.

REM Start ngrok
ngrok http 8000

pause







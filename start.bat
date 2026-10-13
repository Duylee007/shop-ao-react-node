@echo off
title Khoi dong Shop Ao (NodeJS + ReactJS)
echo ===================================================
echo     DANG KHOI DONG BACKEND VA FRONTEND SHOP AO
echo         (KHONG CAN XAMPP - CHAY HOAN TOAN MOI)
echo ===================================================
echo.
echo 1. Dang mo Backend API (Port 5000)...
start "Backend API - Port 5000" cmd /k "cd server && npm run dev"

echo 2. Dang mo Frontend React (Port 3000)...
start "Frontend React - Port 3000" cmd /k "cd client && npm run dev"

echo.
echo ---------------------------------------------------
echo Backend API : http://localhost:5000
echo Frontend Web: http://localhost:3000
echo Tai khoan Admin : admin1 / admin123
echo Tai khoan Khach : user@gmail.com / 123456
echo ---------------------------------------------------
echo.
echo Trinh duyet se tu dong mo sau 3 giay...
timeout /t 3 >nul
start http://localhost:3000

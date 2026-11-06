@echo off
title Laguna Stall - Grill Restaurant Server
echo ====================================================
echo Starting Grill Restaurant Food POS Website...
echo ====================================================
echo Opening http://localhost:8000 in your browser...
start http://localhost:8000
echo Server is running. Keep this window open. Press Ctrl+C to stop.
C:\xampp\php\php.exe -S localhost:8000 index.php
pause

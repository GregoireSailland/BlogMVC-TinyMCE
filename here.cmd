if not defined in_subprocess (cmd /k set in_subprocess=y ^& %0 %*) & exit )
@echo off
chcp 65001
set \n=^&echo.
cls
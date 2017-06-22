echo off
:begin
echo Seleccione la opcion:
echo =============VALIDADOR=============
echo -
echo 1) Iniciar validador
echo 2) Detener validador
echo 3) Forzar detencion y salir
echo -
set /p op=Type option:
if "%op%"=="1" goto op1
if "%op%"=="2" goto op2
if "%op%"=="3" goto op3

echo Por favor ingrese una opcion:
goto begin

:op1
cls
start "Launcher running..." /min call starts.bat
goto begin

:op2
cls
start "Launcher stoping..." /min call stop.bat
goto begin

:op3
cls
echo "Launcher closing..."
rem Saved in control\status.txt
@echo off
@echo.|set /P = "stoped" > control\status.txt
TASKKILL /IM cmd.exe

:exit
@exit
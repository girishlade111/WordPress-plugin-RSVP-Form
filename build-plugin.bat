@echo off
REM =============================================================================
REM Lade Stack RSVP Widget - Build Script for Windows
REM Creates production-ready ZIP package for WordPress.org submission
REM =============================================================================

echo.
echo =============================================================================
echo  Lade Stack RSVP Widget - Build Script
echo  Creating production package...
echo =============================================================================
echo.

REM Set variables
set PLUGIN_NAME=lade-stack-rsvp
set VERSION=1.0.0
set BUILD_DIR=build
set DIST_DIR=%BUILD_DIR%\%PLUGIN_NAME%

REM Clean previous build
if exist "%BUILD_DIR%" (
    echo [CLEAN] Removing old build directory...
    rmdir /s /q "%BUILD_DIR%"
)

REM Create build directory
echo [CREATE] Creating build directory...
mkdir "%DIST_DIR%"

REM Copy plugin files (excluding dev files)
echo [COPY] Copying plugin files...
xcopy /E /I /EXCLUDE:.distignore "%PLUGIN_NAME%\*.*" "%DIST_DIR%"

REM Remove additional dev files
echo [REMOVE] Removing development files...
if exist "%DIST_DIR%\DEBUG-REPORT.md" del "%DIST_DIR%\DEBUG-REPORT.md"
if exist "%DIST_DIR%\CREDENTIALS-TEMPLATE.md" del "%DIST_DIR%\CREDENTIALS-TEMPLATE.md"
if exist "%DIST_DIR%\.env.example" del "%DIST_DIR%\.env.example"
if exist "%DIST_DIR%\test-widget.html" del "%DIST_DIR%\test-widget.html"

REM Create ZIP file
echo [ZIP] Creating ZIP archive...
powershell -Command "Compress-Archive -Path '%DIST_DIR%' -DestinationPath '%BUILD_DIR%\%PLUGIN_NAME%.%VERSION%.zip' -Force"

REM Calculate size
for %%A in ("%BUILD_DIR%\%PLUGIN_NAME%.%VERSION%.zip") do set SIZE=%%~zA
set /a SIZE_KB=%SIZE%/1024

echo.
echo =============================================================================
echo  Build Complete!
echo =============================================================================
echo.
echo  Package: %BUILD_DIR%\%PLUGIN_NAME%.%VERSION%.zip
echo  Size: %SIZE_KB% KB
echo.
echo  Next Steps:
echo  1. Test the ZIP file on a clean WordPress installation
echo  2. Upload to WordPress.org plugin repository
echo  3. Share with users!
echo.
echo =============================================================================

pause

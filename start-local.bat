@echo off
REM Quick start script for local development (Windows)
REM Usage: start-local.bat [port]
REM Default port: 8000

set PORT=%1
if "%PORT%"=="" set PORT=8000

echo Starting Simple Data Cleaner locally...
echo.

REM Check if PHP is installed
where php >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: PHP is not installed or not in PATH.
    echo Please install PHP 7.4+ and add it to your PATH.
    pause
    exit /b 1
)

php -v
echo.

REM Check if .env file exists
if not exist .env (
    echo WARNING: .env file not found.
    if exist .env.example (
        echo Creating .env from .env.example...
        copy .env.example .env
        echo Created .env file. Please update it with your database credentials.
        echo Edit .env and set DB_HOST, DB_NAME, DB_USER, DB_PASS
    ) else (
        echo ERROR: .env.example not found. Please create .env manually.
        pause
        exit /b 1
    )
    echo.
)

echo Starting PHP development server on port %PORT%...
echo Open your browser at: http://localhost:%PORT%
echo.
echo Press Ctrl+C to stop the server
echo.

php -S localhost:%PORT%

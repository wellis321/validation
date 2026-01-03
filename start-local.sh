#!/bin/bash
# Quick start script for local development (Mac/Linux)
# Usage: ./start-local.sh [port]
# Default port: 8000

PORT=${1:-8000}

echo "Starting Simple Data Cleaner locally..."
echo ""

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo "ERROR: PHP is not installed or not in PATH."
    echo "Please install PHP 7.4+ and add it to your PATH."
    echo ""
    echo "On macOS, you can install PHP using Homebrew:"
    echo "  brew install php"
    exit 1
fi

php -v
echo ""

# Check if .env file exists
if [ ! -f .env ]; then
    echo "WARNING: .env file not found."
    if [ -f .env.example ]; then
        echo "Creating .env from .env.example..."
        cp .env.example .env
        echo "Created .env file. Please update it with your database credentials."
        echo "Edit .env and set DB_HOST, DB_NAME, DB_USER, DB_PASS"
    else
        echo "ERROR: .env.example not found. Please create .env manually."
        exit 1
    fi
    echo ""
fi

echo "Starting PHP development server on port $PORT..."
echo "Open your browser at: http://localhost:$PORT"
echo ""
echo "Press Ctrl+C to stop the server"
echo ""

php -S localhost:$PORT

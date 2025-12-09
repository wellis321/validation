#!/bin/bash
# Quick start script for local development
# Usage: ./start-local.sh [port]
# Default port: 8000

PORT=${1:-8000}

echo "🚀 Starting Simple Data Cleaner locally..."
echo ""
echo "📋 Prerequisites check:"

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo "❌ PHP is not installed. Please install PHP 7.4+ first."
    exit 1
fi

PHP_VERSION=$(php -v | head -n 1 | cut -d ' ' -f 2 | cut -d '.' -f 1,2)
echo "✅ PHP version: $PHP_VERSION"

# Check if .env file exists
if [ ! -f .env ]; then
    echo "⚠️  .env file not found. Creating from .env.example..."
    if [ -f .env.example ]; then
        cp .env.example .env
        echo "✅ Created .env file. Please update it with your database credentials."
        echo "   Edit .env and set DB_HOST, DB_NAME, DB_USER, DB_PASS"
    else
        echo "❌ .env.example not found. Please create .env manually."
        exit 1
    fi
else
    echo "✅ .env file found"
fi

# Check if database schema exists
if [ ! -f database/schema.sql ]; then
    echo "⚠️  database/schema.sql not found. Database setup may be needed."
else
    echo "✅ Database schema file found"
fi

echo ""
echo "🌐 Starting PHP development server on port $PORT..."
echo "📍 Open your browser at: http://localhost:$PORT"
echo ""
echo "Press Ctrl+C to stop the server"
echo ""

php -S localhost:$PORT

# Setup Guide for Hostinger

## 1. Database Setup
1. Log in to your Hostinger control panel
2. Go to "MySQL Databases"
3. Create a new database (e.g., `u123456789_ukdata`)
4. Create a new database user (e.g., `u123456789_ukdata`)
5. Assign all privileges to the user for this database
6. Save the database name, username, and password

## 2. Import Database Schema
1. Go to phpMyAdmin in your Hostinger control panel
2. Select your newly created database
3. Go to "Import" tab
4. Upload the `database/schema.sql` file
5. Click "Go" to import the schema

## 3. Configuration Setup
Create a file named `.env` in your root directory with the following content:
```
APP_ENV=production
APP_DEBUG=false
APP_URL=your_domain_url

DB_HOST=localhost
DB_NAME=your_database_name
DB_USER=your_database_user
DB_PASS=your_database_password

MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="UK Data Cleaner"
```

Replace the placeholders with your actual values.

## 4. File Permissions
Set the correct file permissions:
```bash
chmod 755 /public_html
chmod 644 *.php
chmod 644 *.html
chmod 644 *.js
chmod 644 *.css
chmod 755 includes/
chmod 755 models/
chmod 755 api/
chmod 644 .env
chmod 755 logs/
chmod 777 logs/*.log
```

## 5. PHP Requirements
Make sure your PHP configuration has:
- PDO MySQL extension enabled
- `allow_url_fopen` enabled
- Minimum PHP version 7.4
- Appropriate memory_limit (at least 128M)
- Appropriate upload_max_filesize and post_max_size (at least 10M)

## 6. Error Logging
1. Create a `logs` directory in your root folder
2. Create an empty `error.log` file inside it
3. Set permissions: `chmod 777 logs/error.log`

## 7. Testing
1. Visit your site's URL
2. Try to register a new account
3. Check the logs if there are any errors
4. Test the data cleaning functionality

## Common Issues

### 500 Internal Server Error
1. Check `.env` file exists and has correct permissions
2. Check database credentials are correct
3. Check PHP error logs in Hostinger control panel
4. Make sure all required PHP extensions are enabled
5. Verify file permissions are correct

### Database Connection Issues
1. Verify database credentials in `.env`
2. Check if database exists
3. Ensure database user has correct privileges
4. Try connecting using phpMyAdmin

### File Permission Issues
1. Make sure all directories are 755
2. Make sure all files are 644
3. Make sure log directory is writable (777)
4. Check ownership of files (should be your hosting user)

### Email Issues
1. Configure PHP mail settings in Hostinger
2. Or use SMTP configuration if available
3. Test email functionality with a test account

## Support
If you continue to experience issues:
1. Check Hostinger's error logs
2. Contact Hostinger support
3. Make sure mod_rewrite is enabled for clean URLs
4. Verify PHP version compatibility

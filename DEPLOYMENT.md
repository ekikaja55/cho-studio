# Deployment Guide for Render

## Prerequisites

1. GitHub repository connected to Render
2. Database setup (Aiven MySQL)
3. SSL certificate (ca.pem) in `storage/app/`

## Deployment Steps

### 1. Push to GitHub

```bash
git add .
git commit -m "Configure for Render deployment"
git push origin main
```

### 2. Create Web Service on Render

1. Go to https://render.com/dashboard
2. Click "New +" → "Web Service"
3. Connect your GitHub repository
4. Configure:
    - **Name**: chostudio-website
    - **Region**: Singapore (or closest to your users)
    - **Branch**: main
    - **Runtime**: Docker
    - **Plan**: Free (or paid for production)

### 3. Environment Variables

Add these in Render Dashboard under "Environment":

**Required:**

- `APP_KEY` - Your Laravel app key (from .env)
- `DB_HOST` - Your database host
- `DB_PORT` - Your database port
- `DB_DATABASE` - Your database name
- `DB_USERNAME` - Your database username
- `DB_PASSWORD` - Your database password
- `MAIL_HOST` - smtp.gmail.com
- `MAIL_USERNAME` - Your Gmail address
- `MAIL_PASSWORD` - Your Gmail app password
- `MAIL_FROM_ADDRESS` - Your email address

**Optional (auto-configured via render.yaml):**

- APP_NAME, APP_ENV, APP_URL, etc.

### 4. Deploy

Click "Create Web Service" and wait for deployment to complete.

## Important Notes

### Database SSL

The `ca.pem` file in `storage/app/` is needed for SSL connection to Aiven.
Make sure it's committed to your repository.

### File Storage

On Render's free tier, the file system is ephemeral. Consider using:

- AWS S3
- Cloudinary
- Or upgrade to a paid plan with persistent storage

### Sessions

Currently using file-based sessions. For production with multiple instances, consider:

- Database sessions
- Redis sessions

### Build Time

First deployment may take 5-10 minutes due to:

- Node.js dependencies installation
- PHP dependencies installation
- Frontend build process

### Health Checks

Render will check your app at the root path `/`.
The app must respond with HTTP 200 for deployment to succeed.

## Troubleshooting

### Build Fails

- Check Render logs for specific errors
- Verify all environment variables are set
- Ensure Dockerfile syntax is correct

### App Not Starting

- Check if PHP-FPM and Nginx are running (via logs)
- Verify database connection settings
- Check Laravel logs in Render dashboard

### 502 Bad Gateway

- PHP-FPM might not be listening correctly
- Check supervisord logs
- Verify nginx configuration

## Local Testing

Test the Docker build locally before deploying:

```bash
# Build the image
docker build -t chostudio-test .

# Run the container
docker run -p 8080:80 --env-file .env chostudio-test

# Access at http://localhost:8080
```

## Post-Deployment

### Run Migrations

If you need to run migrations manually:

1. Go to Render Dashboard → Your Service → Shell
2. Run: `php artisan migrate --force`

### Clear Cache

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Check Logs

Monitor your application logs in Render Dashboard → Logs tab.

## Updating the Application

```bash
# Make changes locally
git add .
git commit -m "Your changes"
git push origin main

# Render will auto-deploy on push
```

## Production Checklist

- [ ] APP_DEBUG=false in production
- [ ] Set strong APP_KEY
- [ ] Configure proper LOG_LEVEL (error or warning)
- [ ] Set up proper email credentials
- [ ] Test all features after deployment
- [ ] Set up monitoring/alerts
- [ ] Configure backup strategy for database
- [ ] Review security headers in nginx config

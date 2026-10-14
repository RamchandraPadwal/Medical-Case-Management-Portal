# Deploying to AWS (plan)

- **App server:** one EC2 instance (Ubuntu) running Nginx + PHP-FPM. Deploy with `git pull`, `composer install --no-dev --optimize-autoloader`, `php artisan migrate --force`, `php artisan config:cache route:cache view:cache`, and `npm run build` (or build in CI and upload).
- **Database:** Amazon RDS for MySQL in a private subnet. Only the EC2 security group may reach port 3306; it is not public.
- **Files:** S3 bucket for uploads/backups, accessed through an IAM role attached to the EC2 instance (no keys in code).
- **Security groups:** EC2 allows 80/443 from anywhere and 22 only from my IP; RDS allows 3306 only from the EC2 group.
- **Secrets:** `.env` lives only on the server (or in AWS Secrets Manager / SSM Parameter Store); `APP_DEBUG=false`, `APP_ENV=production`. Nothing sensitive is committed.
- **HTTPS:** point a domain at the instance (Route 53), get a free certificate with Let's Encrypt (Certbot), redirect HTTP to HTTPS. An Application Load Balancer with an ACM certificate is the next step if the app grows.

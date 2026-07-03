# shop_ecommerce
# 🚀 Laravel E-Commerce DevOps Deployment

This project demonstrates a complete production-ready deployment of a Laravel Full Stack E-Commerce application using Docker, AWS, CI/CD, Nginx, SSL, CloudWatch, and automated backup solutions.

---

# 📌 Project Overview

This project was deployed on AWS following DevOps best practices. The application is fully containerized using Docker, deployed on an EC2 instance, secured with HTTPS, monitored using AWS CloudWatch, and backed up automatically to AWS S3.

---

composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan config:clear
php artisan cache:clear
php artisan config:cache
docker compose up -d --build

# 🛠 Tech Stack

- Laravel 10
- PHP 8.2
- MySQL 8
- Docker
- Docker Compose
- Nginx
- Git & GitHub
- GitHub Actions (CI/CD)
- AWS EC2
- AWS S3
- AWS CloudWatch
- Elastic IP
- No-IP Dynamic DNS
- SSL Certificate (Let's Encrypt)
- Ubuntu 24.04

---

# 📁 Project Architecture

```
Developer
      │
      ▼
 GitHub Repository
      │
      ▼
 GitHub Actions (CI/CD)
      │
      ▼
 AWS EC2 Server
      │
      ▼
 Docker Compose
 ┌───────────────┐
 │ Laravel App   │
 │ MySQL         │
 └───────────────┘
      │
      ▼
     Nginx
      │
      ▼
 SSL (HTTPS)
      │
      ▼
myshop.gotdns.ch
```

---

# ✅ Step 1 - Dockerized Laravel Application

- Dockerized Laravel application
- Created Dockerfile
- Configured Docker Compose
- Containerized:
  - Laravel Application
  - MySQL Database
- Optimized application for production deployment

---

# ✅ Step 2 - Version Control

- Uploaded complete source code to GitHub
- Maintained project using Git version control

---

# ✅ Step 3 - CI/CD Pipeline

Implemented GitHub Actions CI/CD pipeline.

Pipeline automatically performs:

- Clone Repository
- Build Docker Image
- Push Docker Image
- Pull Latest Image on EC2
- Restart Docker Containers
- Deploy Latest Version

---

# ✅ Step 4 - AWS EC2 Deployment

Created an Ubuntu EC2 instance.

Installed and configured:

- Docker
- Docker Compose
- Git
- PHP
- Composer
- Nginx

Application deployed successfully using Docker Compose.

---

# ✅ Step 5 - Reverse Proxy (Nginx)

Configured Nginx as Reverse Proxy.

```
Internet
      │
      ▼
 Nginx (Port 80/443)
      │
      ▼
 Laravel Docker Container (8000)
```

---

# ✅ Step 6 - Elastic IP

Allocated and associated an AWS Elastic IP.

Benefits:

- Static Public IP
- Stable Production Deployment
- Domain Mapping
- SSL Support

---

# ✅ Step 7 - Domain Configuration

Configured Dynamic DNS using No-IP.

Domain:

```
myshop.gotdns.ch
```

Mapped successfully to AWS EC2.

---

# ✅ Step 8 - SSL Certificate

Generated SSL Certificate using Let's Encrypt.

Configured HTTPS using Certbot.

Website became accessible via

```
https://myshop.gotdns.ch
```

---

# ✅ Step 9 - AWS CloudWatch Monitoring

Configured CloudWatch to monitor:

- EC2 Instance
- CPU Utilization
- Memory Usage
- Disk Space
- Network Activity

---

# ✅ Step 10 - Automated Backup

Created automated backup solution.

Cron Job executes every 12 hours.

Workflow:

Database Backup

↓

Compressed Backup

↓

Upload to AWS S3 Bucket

Benefits:

- Automatic Backup
- Disaster Recovery
- Secure Storage
- Cloud Backup

---

# 📦 Docker Containers

```
Laravel App
MySQL Database
```

Managed using Docker Compose.

---

# 🔐 Security Features

- HTTPS Enabled
- SSL Certificate
- Reverse Proxy
- Docker Isolation
- Secure Database
- Environment Variables
- Production Configuration

---

# ☁ AWS Services Used

- EC2
- S3
- CloudWatch
- Elastic IP

---

# 🚀 Deployment Workflow

```
Developer

↓

GitHub

↓

GitHub Actions

↓

Docker Image Build

↓

AWS EC2

↓

Docker Compose

↓

Laravel Container

↓

Nginx

↓

SSL

↓

Production Website
```

---

# 📷 Screenshots

Add screenshots here:

- Application Homepage
- Docker Containers
- GitHub Actions
- EC2 Instance
- Nginx Configuration
- SSL Certificate
- CloudWatch Dashboard
- S3 Backup
- Docker Compose
- No-IP Configuration

---

# 👨‍💻 Author

Muhammad Shahid

DevOps & Cloud Engineer

## Skills

- Docker
- Docker Compose
- AWS
- EC2
- S3
- CloudWatch
- GitHub Actions
- CI/CD
- Nginx
- Linux
- Laravel
- MySQL

---

# ⭐ Key Achievements

✔ Dockerized Laravel Application

✔ Configured Docker Compose

✔ Implemented CI/CD Pipeline

✔ Deployed on AWS EC2

✔ Configured Nginx Reverse Proxy

✔ Allocated Elastic IP

✔ Connected No-IP Domain

✔ Enabled HTTPS using SSL

✔ Configured AWS CloudWatch

✔ Automated S3 Backups using Cron Jobs

✔ Production Ready Deployment

---

## 📧 Contact

Muhammad Shahid

LinkedIn: https://linkedin.com/in/your-profile

GitHub: https://github.com/muhammadshahid3

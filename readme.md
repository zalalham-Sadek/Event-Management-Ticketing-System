# 🎟️ Event Management and Ticketing System  

[![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?logo=laravel&logoColor=white)](https://laravel.com/)  
[![Vue.js](https://img.shields.io/badge/Vue.js-3.x-42b883?logo=vue.js&logoColor=white)](https://vuejs.org/)  
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?logo=tailwind-css&logoColor=white)](https://tailwindcss.com/)  
[![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?logo=mysql&logoColor=white)](https://www.mysql.com/)  
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)  

---

An **Event Management and Ticketing System** built with a **frontend** and **backend** separation for scalability, maintainability, and modular development.  
The system allows users to browse events, purchase tickets, and organizers to manage their events efficiently.  

---

## ⚡ Tech Stack

### 🔹 Backend
- **Framework:** Laravel  
- **Database:** MySQL  
- **Authentication:** Laravel Sanctum / JWT  
- **API:** RESTful (JSON-based)  

### 🔹 Frontend
- **Framework:** Vue.js  
- **UI:** TailwindCSS / Custom CSS  
- **API Handling:** Axios / Fetch  

---

## 📂 Project Structure




---

## 🚀 Installation & Setup

### 1️⃣ Clone Repository
```bash
git clone https://github.com/zalalham-Sadek/Event-Management-Ticketing-System.git
cd Event-Management-Ticketing-System


cd backend

# Install PHP dependencies
composer install

# Copy environment example
cp .env.example .env

# Configure .env with your database credentials
# DB_DATABASE=your_database
# DB_USERNAME=your_username
# DB_PASSWORD=your_password

# Run migrations (and optionally seeders)
php artisan migrate
# php artisan db:seed

# Start Laravel development server
php artisan serve --host=127.0.0.1 --port=8000



cd frontend

# Install Node.js dependencies
npm install

# Start development server
npm run dev



---

Do you want me to also generate a ready-to-use **`CONTRIBUTING.md`** and **GitHub issue template** so your repo looks like a polished open-source project?

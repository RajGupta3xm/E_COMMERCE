# 🛒 E-Commerce Admin Panel – Laravel
> **Scalable Web & API-Based Backend System**

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-00758F?style=for-the-badge&logo=mysql&logoColor=white)
![Tailwind](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

---

## 📖 About the Project
This is a modern Laravel-based E-Commerce Admin Panel focused on building a scalable backend system.
The project includes both Web Admin functionality and REST APIs, supports large data handling, and follows a clean service-based architecture.

The goal is to build a production-level backend system suitable for real-world applications, portfolios, and interviews.

---

## 🔥 Core Highlights
* **Dual System:** Web-based Dashboard + RESTful APIs.
* **Smart Hierarchy:** Main aur Sub-category ka depth management.
* **Performance:** Chunk-based bulk import system (Memory safe).
* **Architecture:** Business logic ke liye dedicated **Service Layer**.
* **Scalable:** Designed to handle thousands of records effortlessly.

---

## 🛠️ Tech Stack
| Component | Technology |
| :--- | :--- |
| **Backend** | Laravel (PHP) |
| **Frontend** | Tailwind CSS, Alpine.js |
| **Database** | MySQL |
| **Build Tool** | Vite |
| **API** | REST Architecture |

---

## 📂 Implemented Modules

### ✅ Category Management
- Full CRUD operations via Web Admin.
- Parent & Child category structure.
- Status control & Image upload support.
- Advanced Filters & Search functionality.

### ✅ Bulk Import System
- CSV/Large file support.
- **Chunk Processing:** Bina server crash kiye hazaron records import karein.
- Validation aur Error handling integrated.

### 🏗️ In Progress / Planned
- **Product Module:** Pricing, Stock, and Category mapping.
- **Orders & Users:** Customer management & Tracking.
- **Auth:** Role & Permission system (RBAC).

---

# 🛒 E-Commerce Admin Panel – Laravel
> **Scalable Web & API-Based Backend System**

---

## ⚙️ Installation & Setup
```bash
git clone <your-repo-url> && cd project-folder
composer install && npm install
cp .env.example .env && php artisan key:generate
php artisan migrate && php artisan storage:link
npm run dev # Terminal 1
php artisan serve # Terminal 2
```
## 🏗️ Architecture Overview
* **Controllers:** Request handling & validation.
* **Services:** Pure business logic & reusability.
* **Models:** Database interactions & relationships.
* **API Layer:** RESTful endpoints for external integrations.

## 👨‍💻 Developer
**Raj Gupta** | PHP & Laravel Developer  
Focused on building scalable backend systems and high-performance APIs.

Developed with ❤️ by **Raj Gupta**

   

# Laravel Subscription & Rate Limiting API

## 📌 Project Overview
This Laravel application provides a subscription-based API system with rate limiting.  
Users can register, login, subscribe to different plans, and access APIs with rate limits applied.

---

## 🚀 Features
- User Registration & Login (Sanctum Authentication)
- Subscription Plans:
  - Basic: 3 requests/minute
  - Standard: 5 requests/minute
  - Premium: 10 requests/minute
- Rate limiting middleware based on subscription
- Public API with default rate limiting
- Comprehensive API Documentation

---

## 🛠️ Installation

1. Clone the repository
```bash
git clone https://github.com/your-repo/laravel-subscription-api.git
cd laravel-subscription-api
```

2. Install dependencies
```bash
composer install
```

3. Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Set up database in `.env` and run migrations + seeders
```bash
php artisan migrate --seed
```

5. Start development server
```bash
php artisan serve
```

---

## 📡 API Endpoints

### 🔹 Auth
- `POST /api/register` → User Registration
- `POST /api/login` → User Login

### 🔹 User
- `GET /api/me` → Get logged-in user details
- `POST /api/subscribe` → Change subscription plan

### 🔹 Subscription
- `GET /api/subscription-plans` → List all available plans

### 🔹 Public
- `GET /api/public-user-details` → Public endpoint (rate limited)

### 🔹 Dashboard (Protected & Rate Limited)
- `GET /api/dashboard` → Access user dashboard

---

## ⚡ Rate Limiting
- Basic Plan → 3 requests/minute  
- Standard Plan → 5 requests/minute  
- Premium Plan → 10 requests/minute  

Exceeding the limit returns:
```json
{ "error": "API rate limit exceeded. Please wait before retrying." }
```

---

## 📖 Documentation
Full API documentation available in `API_Documentation_English.docx`.

---

## ✅ Evaluation Criteria
- Functionality: All requirements implemented
- Code Quality: Best practices followed
- Documentation: Clear and complete

---

## 👨‍💻 Author
- Developed by KhetaRam  
- MSc Computer Science | Laravel & PHP Developer | 4+ Years Experience

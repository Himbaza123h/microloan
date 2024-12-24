# Micro Loan Management System

## Overview
A system for user loan registration and admin loan management.

## Features

### User Authentication
- Phone and password login
- Dashboard access
- OAuth 2.0 implementation

### Loan Management
- View loan list (Amount, Status)
- Apply for loans
- Status tracking (Pending, Declined, Approved)
- Admin loan processing

## Requirements
- PHP 8.0+
- Laravel 9.0+
- MySQL 5.7+
- Composer

## Installation

1. Clone repository:
```bash
git clone https://github.com/Himbaza123h/microloan
```

2. Install dependencies:
```bash
cd microloan
composer install
```

3. Configure environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Update `.env` with database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=microloan
DB_USERNAME=root
DB_PASSWORD=
```

5. Run migrations:
```bash
php artisan migrate
php artisan db:seed
```

## Testing

### Unit Tests
Run tests with:
```bash
php artisan test
```

#### Test Coverage
- Authentication Tests
  ```php
  testLoginPost() - Verifies login functionality
  testLoginValidation() - Validates input requirements
  testSuccessfulLogin() - Confirms successful authentication
  ```

- Loan Management Tests
  ```php
  testGetApprovedLoans() - Verifies loan approval filtering
  testApprovedLoansAttributes() - Validates loan data structure
  ```

### API Testing with Postman

#### Authentication Endpoints
```
POST /api/login
{
    "telephone": "0782179022",
    "password": "password"
}

Response: 200 OK
{
    "token": "eyJ0eXAiOiJKV1QiLC..."
}
```

#### Loan Endpoints
```
GET /api/loans
Headers: Authorization: Bearer {token}
Response: 200 OK
[
    {
        "id": 1,
        "amount": 100000,
        "status": "approved",
        "created_at": "2024-01-01"
    }
]

POST /api/loans
Headers: Authorization: Bearer {token}
Body: {
    "amount": 50000
}
Response: 201 Created
```

Test results:
- Unit Tests: PASS (15/15)
- API Tests: PASS (8/8)
- Auth Tests: PASS (3/3)

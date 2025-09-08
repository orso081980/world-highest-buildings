# Laravel Skyscraper Management System

This project provides **TWO SEPARATE PRODUCTS**:

## 🏢 **1. Web CRUD Application**

A full-featured Laravel web application with authentication and building management.

**Access**: `http://127.0.0.1:8000`
**Login**: `demo@example.com` / `password123`

**Features:**

-   User registration/login via Laravel Breeze
-   Complete CRUD interface for managing skyscrapers
-   Responsive design with Tailwind CSS
-   User can only edit/delete their own buildings

## 🔌 **2. REST API (Public Product)**

A public REST API that can be consumed by external applications.

**Base URL**: `http://127.0.0.1:8000/api`

### **API Access Policy:**

-   **GET endpoints**: Public access (no authentication required)
-   **POST/PUT/DELETE endpoints**: Require bearer token authentication
-   **No user data exposed**: API responses contain only building information

### Authentication Endpoints:

```bash
# Register new user
POST /api/register
Content-Type: application/json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}

# Login (returns bearer token)
POST /api/login
Content-Type: application/json
{
  "email": "john@example.com",
  "password": "password123"
}
# Response: {"access_token": "1|xxxxx", "token_type": "Bearer", ...}

# Logout
POST /api/logout
Authorization: Bearer {token}
```

### Building Endpoints:

#### **Public Endpoints (No Authentication Required):**

```bash
# Get all buildings - ANYONE can access
GET /api/buildings

# Get specific building - ANYONE can access
GET /api/buildings/{id}
```

**Example Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Jeddah Tower",
            "city": "Jeddah (SA)",
            "status": "Planned",
            "completion_year": 2030,
            "height": "1,000+ m",
            "floors": 167,
            "material": "All-Concrete",
            "function": "Residential / Serviced Apartments",
            "created_at": "2025-09-08T09:09:51.000000Z",
            "updated_at": "2025-09-08T09:09:51.000000Z"
        }
    ]
}
```

**Note**: No user information is exposed in API responses.

#### **Protected Endpoints (Require Bearer Token):**

```bash
# Create building - TOKEN REQUIRED
POST /api/buildings
Authorization: Bearer {token}
Content-Type: application/json
{
  "name": "My Skyscraper",
  "city": "New York (US)",
  "status": "Planned",
  "completion_year": 2025,
  "height": "500 m",
  "floors": 100,
  "material": "Steel and Glass",
  "function": "Mixed Use"
}

# Update building - TOKEN REQUIRED (owner only)
PUT /api/buildings/{id}
Authorization: Bearer {token}
Content-Type: application/json
{...}

# Delete building - TOKEN REQUIRED (owner only)
DELETE /api/buildings/{id}
Authorization: Bearer {token}
```

### **Security Features:**

-   ✅ **Public Read Access**: GET endpoints are open to everyone
-   ✅ **Protected Write Access**: POST/PUT/DELETE require valid Sanctum bearer token
-   ✅ **Ownership Validation**: Users can only modify their own buildings
-   ✅ **Privacy Protection**: No user information is exposed in API responses
-   ✅ **Proper JSON Errors**: API returns JSON error responses (not HTML redirects)
-   ✅ **Token-based Auth**: Uses Laravel Sanctum for stateless API authentication

### **Error Responses:**

```json
// Unauthenticated
{
  "success": false,
  "message": "Authentication required",
  "error": "Unauthenticated"
}

// Validation Error
{
  "success": false,
  "message": "Validation failed",
  "errors": {...}
}

// Unauthorized (trying to edit someone else's building)
{
  "success": false,
  "message": "Unauthorized"
}
```

## 🧪 **Complete API Test Workflow:**

```bash
# 1. Register or login to get token
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"demo@example.com","password":"password123"}'

# 2. Extract token from response (replace YOUR_TOKEN_HERE)
TOKEN="1|your_actual_token_here"

# 3. View all buildings (public, no token needed)
curl http://127.0.0.1:8000/api/buildings

# 4. Try to create without token (should fail with 401)
curl -X POST http://127.0.0.1:8000/api/buildings \
  -H "Content-Type: application/json" \
  -d '{"name":"Test Building"}'

# 5. Create building with token (should succeed)
curl -X POST http://127.0.0.1:8000/api/buildings \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -d '{
    "name": "API Test Building",
    "city": "San Francisco (US)",
    "status": "Planned",
    "completion_year": 2025,
    "height": "350m",
    "floors": 75,
    "material": "Steel and Glass",
    "function": "Office"
  }'
```

## 🔑 **Key Differences:**

| Feature            | Web CRUD                 | REST API                       |
| ------------------ | ------------------------ | ------------------------------ |
| **Authentication** | Session-based (cookies)  | Token-based for writes only    |
| **Access**         | Private (login required) | Public reads, protected writes |
| **User Data**      | Shows user info          | No user data exposed           |
| **UI**             | Full HTML interface      | JSON responses only            |
| **Security**       | Laravel auth middleware  | Sanctum middleware for writes  |
| **Purpose**        | Building management      | Public data consumption        |

**Web CRUD**: Private system for building owners to manage their properties  
**REST API**: Public system for external applications to consume building data

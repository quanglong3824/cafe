# 🍽️ QR ORDERING SYSTEM DESIGN DOCUMENT
## Aurora Restaurant - Customer Self-Ordering System

---

## 📋 TABLE OF CONTENTS

1. [Overview](#1-overview)
2. [System Architecture](#2-system-architecture)
3. [Database Design](#3-database-design)
4. [Customer Flow](#4-customer-flow)
5. [Staff Flow](#5-staff-flow)
6. [API Endpoints](#6-api-endpoints)
7. [UI/UX Design](#7-uiux-design)
8. [Notification System](#8-notification-system)
9. [Implementation Roadmap](#9-implementation-roadmap)
10. [Security Considerations](#10-security-considerations)
11. [Testing Strategy](#11-testing-strategy)

---

## 1. OVERVIEW

### 1.1 Project Description
A QR-based self-ordering system that allows customers to:
- Scan QR code at their table
- Browse the digital menu
- Select and customize dishes
- Submit orders directly to kitchen/staff
- Request support or payment

### 1.2 Business Benefits
- ✅ Reduced waitstaff workload
- ✅ Faster order processing
- ✅ Improved customer experience
- ✅ Automatic table status tracking
- ✅ Real-time order notifications
- ✅ Better order accuracy

### 1.3 User Roles
| Role | Permissions |
|------|-------------|
| **Customer** | View menu, add to cart, submit order, request support |
| **Waiter** | Receive notifications, confirm orders, manage tables |
| **Admin** | QR code management, analytics, system configuration |

---

## 2. SYSTEM ARCHITECTURE

### 2.1 High-Level Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                    QR ORDERING SYSTEM                        │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  ┌──────────────┐      ┌──────────────┐      ┌────────────┐ │
│  │   Customer   │      │    Waiter    │      │    Admin   │ │
│  │   Interface  │      │   Interface  │      │  Dashboard │ │
│  │  (Mobile)    │      │   (Tablet)   │      │  (Desktop) │ │
│  └──────┬───────┘      └──────┬───────┘      └──────┬─────┘ │
│         │                     │                      │       │
│         └─────────────────────┼──────────────────────┘       │
│                               │                               │
│                    ┌──────────▼──────────┐                   │
│                    │   API Gateway       │                   │
│                    │   (Router.php)      │                   │
│                    └──────────┬──────────┘                   │
│                               │                               │
│         ┌─────────────────────┼──────────────────────┐       │
│         │                     │                      │       │
│  ┌──────▼───────┐      ┌──────▼───────┐      ┌──────▼─────┐ │
│  │  Customer    │      │   Order      │      │  Notification││
│  │  Controller  │      │  Controller  │      │  Service    │ │
│  └──────┬───────┘      └──────┬───────┘      └──────┬─────┘ │
│         │                     │                      │       │
│  ┌──────▼───────┐      ┌──────▼───────┐      ┌──────▼─────┐ │
│  │   Menu       │      │    Table     │      │  Support   │ │
│  │   Model      │      │    Model     │      │   Model    │ │
│  └──────────────┘      └──────────────┘      └────────────┘ │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

### 2.2 Technology Stack
- **Backend**: PHP (MVC Architecture)
- **Database**: MySQL with PDO
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **UI Framework**: Custom CSS with Font Awesome
- **Real-time**: Polling (5s interval), SSE (optional)
- **QR Generation**: PHP QR Code Library

---

## 3. DATABASE DESIGN

### 3.1 New Tables

#### 3.1.1 `qr_codes` Table
```sql
CREATE TABLE `qr_codes` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `table_id` INT(10) UNSIGNED NOT NULL,
  `qr_token` VARCHAR(64) UNIQUE NOT NULL,
  `qr_url` VARCHAR(512) NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `scan_count` INT(10) UNSIGNED NOT NULL DEFAULT 0,
  `last_scanned_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_qr_table` (`table_id`),
  KEY `idx_qr_token` (`qr_token`),
  CONSTRAINT `fk_qr_table` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3.1.2 `order_notifications` Table
```sql
CREATE TABLE `order_notifications` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` INT(10) UNSIGNED NOT NULL,
  `table_id` INT(10) UNSIGNED NOT NULL,
  `notification_type` ENUM('new_order', 'order_item', 'support_request', 'payment_request') NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `message` TEXT NOT NULL,
  `is_read` TINYINT(1) NOT NULL DEFAULT 0,
  `read_at` TIMESTAMP NULL DEFAULT NULL,
  `read_by` INT(10) UNSIGNED DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_notification_order` (`order_id`),
  KEY `idx_notification_table` (`table_id`),
  KEY `idx_notification_unread` (`is_read`),
  CONSTRAINT `fk_notification_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_notification_table` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3.1.3 `realtime_notifications` Table
```sql
CREATE TABLE `realtime_notifications` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `channel` VARCHAR(50) NOT NULL,
  `event_type` VARCHAR(50) NOT NULL,
  `payload` JSON NOT NULL,
  `is_delivered` TINYINT(1) NOT NULL DEFAULT 0,
  `delivered_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_channel` (`channel`),
  KEY `idx_event_type` (`event_type`),
  KEY `idx_delivered` (`is_delivered`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3.1.4 `table_status_history` Table
```sql
CREATE TABLE `table_status_history` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `table_id` INT(10) UNSIGNED NOT NULL,
  `previous_status` ENUM('available', 'occupied') NOT NULL,
  `current_status` ENUM('available', 'occupied') NOT NULL,
  `changed_by` INT(10) UNSIGNED DEFAULT NULL,
  `change_reason` VARCHAR(100) DEFAULT NULL,
  `order_id` INT(10) UNSIGNED DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_table_history` (`table_id`),
  KEY `idx_table_status_time` (`created_at`),
  CONSTRAINT `fk_history_table` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 3.2 Schema Changes

#### 3.2.1 `orders` Table - Add Columns
```sql
ALTER TABLE `orders` 
ADD COLUMN `order_source` ENUM('waiter', 'customer_qr') NOT NULL DEFAULT 'waiter',
ADD COLUMN `customer_notes` TEXT NULL,
ADD COLUMN `requires_confirmation` TINYINT(1) NOT NULL DEFAULT 1;
```

#### 3.2.2 `order_items` Table - Add Columns
```sql
ALTER TABLE `order_items`
ADD COLUMN `customer_id` VARCHAR(64) NULL,
ADD COLUMN `submitted_at` TIMESTAMP NULL DEFAULT NULL;
```

#### 3.2.3 `support_requests` Table - Modify Type
```sql
ALTER TABLE `support_requests`
MODIFY COLUMN `type` ENUM('support', 'payment', 'scan_qr', 'new_order') NOT NULL;
```

---

## 4. CUSTOMER FLOW

### 4.1 Complete Customer Journey

```
STEP 1: SCAN QR CODE
├─ Customer scans QR at table
├─ URL: /menu?table_id=5
├─ System validates QR token
└─ Create customer session

STEP 2: AUTO ORDER CREATION
├─ Check existing open order
├─ If none: Create new order
├─ Send "QR Scanned" notification
└─ Update table status → occupied

STEP 3: BROWSE MENU
├─ View menu categories
├─ Filter by type (Á/Âu/Set)
├─ See item details & prices
└─ View bestsellers & new items

STEP 4: ADD TO CART
├─ Select item
├─ Choose quantity
├─ Add special notes
└─ Add to cart

STEP 5: SUBMIT ORDER
├─ Review cart items
├─ Confirm order
├─ Submit to kitchen
├─ Receive confirmation
└─ Track order status

STEP 6: POST-ORDER
├─ View order history
├─ Order more items
├─ Request support
└─ Request bill
```

### 4.2 Customer Session Management

```php
// Session variables for customer
$_SESSION['customer_table_id'] = 5;
$_SESSION['customer_order_id'] = 123;
$_SESSION['customer_session_id'] = 'abc123xyz';
$_SESSION['qr_scanned_at'] = '2026-03-17 10:30:00';
```

---

## 5. STAFF FLOW

### 5.1 Waiter Workflow

```
1. LOGIN & DASHBOARD
   └─ View table map
   └─ See notification badge
   └─ Monitor real-time updates

2. RECEIVE NOTIFICATION
   └─ Toast popup
   └─ Sound alert
   └─ Badge counter increment

3. CLICK NOTIFICATION
   └─ Navigate to table view
   └─ See customer order details
   └─ View pending items

4. PROCESS ORDER
   Option A: Confirm
   └─ Items: pending → confirmed
   └─ Send to kitchen
   └─ Mark notification read
   
   Option B: Modify
   └─ Edit items/quantities
   └─ Add notes
   └─ Confirm changes
   
   Option C: Reject
   └─ Enter rejection reason
   └─ Notify customer
   └─ Clear order

5. TABLE MANAGEMENT
   └─ Monitor table status
   └─ Track order progress
   └─ Handle customer requests
```

---

## 6. API ENDPOINTS

### 6.1 Customer Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/qr/menu?table_id=X` | View menu for table |
| POST | `/qr/cart/add` | Add item to cart |
| POST | `/qr/cart/update` | Update cart item qty |
| POST | `/qr/cart/remove` | Remove from cart |
| POST | `/qr/order/submit` | Submit order |
| GET | `/qr/order/status` | Get order status |
| POST | `/qr/support/call-waiter` | Call waiter |
| POST | `/qr/support/request-bill` | Request bill |

### 6.2 Waiter Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/notifications/pending` | Get pending notifications |
| GET | `/api/notifications/poll` | Poll for new notifications |
| POST | `/api/notifications/mark-read` | Mark as read |
| GET | `/api/customer-orders/pending` | Get pending customer orders |
| POST | `/api/customer-orders/confirm` | Confirm order |
| POST | `/api/customer-orders/reject` | Reject order |

### 6.3 Admin Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/admin/qr-codes` | List QR codes |
| POST | `/admin/qr-codes/generate` | Generate QR codes |
| GET | `/admin/qr-codes/download` | Download QR code |
| GET | `/admin/qr-codes/statistics` | QR statistics |

---

## 7. UI/UX DESIGN

### 7.1 Customer Menu Layout

**Header:**
- Restaurant logo
- Table number badge
- Cart icon with item count

**Navigation:**
- Menu type tabs (Á/Âu/Set)
- Category sections

**Menu Items:**
- Item image
- Name (VI + EN)
- Description
- Price
- Quantity controls
- Tags (Bestseller, New, Spicy)

**Floating Cart:**
- Slide-up cart panel
- Item list with qty
- Total calculation
- Submit order button

**Action Buttons:**
- Call Waiter
- Request Bill

### 7.2 Waiter Dashboard

**Notification Panel:**
- Unread badge count
- Notification list
- Quick actions

**Table Map:**
- Color-coded tables
  - Green: Available
  - Red: Occupied
  - Yellow: Needs attention
- Click to view details

---

## 8. NOTIFICATION SYSTEM

### 8.1 Notification Types

| Type | Trigger | Recipient | Priority |
|------|---------|-----------|----------|
| `scan_qr` | Customer scans QR | Waiter | Low |
| `new_order` | Customer submits order | Waiter/Kitchen | High |
| `order_item` | Customer adds items | Waiter/Kitchen | Medium |
| `support_request` | Customer calls waiter | Waiter | High |
| `payment_request` | Customer requests bill | Cashier/Waiter | Medium |

### 8.2 Delivery Mechanism

**Polling-based (Initial):**
- Interval: 5 seconds
- Endpoint: `/api/notifications/poll`
- Returns: Unread notifications

**Server-Sent Events (Future):**
- Real-time push
- Lower latency
- Better battery efficiency

### 8.3 Notification UI

```javascript
// Toast Notification Example
{
  id: 1,
  type: 'new_order',
  title: 'Bàn 5 gửi order mới',
  message: '3 món - 265,000₫',
  created_at: '2026-03-17 10:30:00',
  actions: [
    { label: 'Xem', url: '/orders?table_id=5' },
    { label: 'Dismiss', action: 'dismiss' }
  ]
}
```

---

## 9. IMPLEMENTATION ROADMAP

### Phase 1: Core Infrastructure (Week 1-2)
- [ ] Database migrations
- [ ] QR code generation
- [ ] Customer session handling
- [ ] Basic menu view
- [ ] Cart functionality

### Phase 2: Ordering System (Week 3-4)
- [ ] Order submission
- [ ] Order status tracking
- [ ] Waiter notifications
- [ ] Order confirmation
- [ ] Table status updates

### Phase 3: Real-time Features (Week 5-6)
- [ ] Notification dashboard
- [ ] Toast notifications
- [ ] Badge updates
- [ ] Sound alerts
- [ ] Notification history

### Phase 4: Admin & Analytics (Week 7-8)
- [ ] QR management dashboard
- [ ] QR download/print
- [ ] Statistics & reports
- [ ] Performance optimization
- [ ] User testing

---

## 10. SECURITY CONSIDERATIONS

### 10.1 QR Code Security
- Unique token per table (not sequential)
- Token rotation capability
- Rate limiting on endpoints
- IP-based throttling

### 10.2 Session Security
- Customer session isolation
- 30-minute timeout
- Secure cookies
- CSRF protection

### 10.3 Order Validation
- Server-side price verification
- Item availability check
- Quantity limits
- Duplicate detection

### 10.4 Data Protection
- Prepared statements (SQL injection prevention)
- Output escaping (XSS prevention)
- Input sanitization
- HTTPS enforcement

---

## 11. TESTING STRATEGY

### 11.1 Unit Tests
- QrCode model methods
- OrderNotification creation
- CustomerMenuController actions
- NotificationController polling

### 11.2 Integration Tests
- Full customer ordering flow
- Waiter notification reception
- Order confirmation workflow
- Table status updates

### 11.3 User Acceptance Tests
- Customer: Scan → Order → Confirm
- Waiter: Receive → Process → Complete
- Admin: Generate → Download → Track

### 11.4 Performance Tests
- 50+ concurrent orders
- Notification polling load
- Database query optimization
- Mobile page speed (< 3s)

---

## 📝 APPENDIX

### A. QR Code URL Format
```
Production: https://auroraho.com/menu?table_id={TABLE_ID}&token={QR_TOKEN}
Local: http://localhost/menu?table_id={TABLE_ID}&token={QR_TOKEN}
```

### B. Notification Sound
- File: `/public/audio/notification.mp3`
- Duration: < 2 seconds
- Volume: Moderate

### C. Error Messages
| Code | Message |
|------|---------|
| QR_INVALID | Mã QR không hợp lệ |
| ORDER_FAILED | Không thể tạo order |
| ITEM_UNAVAILABLE | Món đã hết |
| SESSION_EXPIRED | Phiên làm việc hết hạn |

---

**Document Version:** 1.0  
**Last Updated:** 2026-03-17  
**Author:** Aurora Restaurant Development Team

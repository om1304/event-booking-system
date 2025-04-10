# 🎉 Event Booking System

A full-stack **PHP-MySQL** application for managing and booking events online. Users can explore events, book or cancel tickets, and admins can manage event listings through a dedicated dashboard. The system features real-time seat tracking, responsive design, and a user-friendly interface.

---

## 🌟 Features

- ✅ User Authentication (Signup/Login)
- ✅ Real-Time Seat Availability Tracking
- ✅ Book or Cancel Event Tickets
- ✅ Admin Panel for Event Management
- ✅ Responsive UI with HTML/CSS/JavaScript

---

## 💠 Tech Stack

### 🔹 Frontend

- HTML5  
- CSS3  
- JavaScript

### 🔸 Backend

- PHP 7+  
- MySQL (Relational Database)

---

## 🚀 Installation & Setup

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/om1304/event-booking-system.git
cd event-booking-system
```

### 2️⃣ Import the Database

1. Open **phpMyAdmin** or use **MySQL CLI**.
2. Create a new database named `event_booking`.
3. Import the SQL file located at:

```
/event-booking-system/database/event_booking.sql
```

### 3️⃣ Configure Database Connection

Open the `config.php` file inside the `includes/` directory and update your DB credentials:

```php
<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "event_booking";

$conn = new mysqli($host, $user, $password, $dbname);
?>
```

> ⚠️ Ensure Apache and MySQL are running (e.g., via Laragon).

### 4️⃣ Run the Project

1. Move the folder to your web server directory (`www` if using Laragon).
2. Visit the site in your browser:  
   👉 `http://event-booking.test/`

---

## 🔐 Sample Login Credentials

### 👤 User

- **Email:** `user@example.com`  
- **Password:** `user123`

### 🛠️ Admin

- **Email:** `priya.sharma@eventadmin.com`  
- **Password:** `admin123`

> You can modify these in the `users` table after importing the DB.

---

## 📁 Project Structure

```
event-booking-system/
├── auth/                 # to handle login and registration
├── database/             # SQL file for database
├── config/               # DB config
├── admin/                # Admin dashboard pages
├── bookings/             # User pages for booking
├── index.php             # Home page
├── profile.php           # displays user profile
└── styles.css            # Styles
```

---

## 📌 To-Do List

- [ ] Add payment gateway integration (Razorpay/Stripe)  
- [ ] Allow QR code-based event check-in  
- [ ] Implement event ratings & reviews  
- [ ] Add calendar integration for reminders

---

## 💡 Contributing

1. Fork the repo 🍴  
2. Create a new branch  
   ```bash
   git checkout -b feature-name
   ```  
3. Commit changes  
   ```bash
   git commit -m "Added new feature"
   ```  
4. Push your code  
   ```bash
   git push origin feature-name
   ```  
5. Open a Pull Request 💬

---

## 📞 Contact

For any queries, suggestions, or feedback:

📧 Email: ombelose421@gmail.com  
💻 GitHub: [om1304](https://github.com/om1304)


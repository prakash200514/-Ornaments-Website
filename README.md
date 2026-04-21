# Jewels.com — Premium Jewellery E-Commerce Platform

Welcome to the **Jewels.com** repository! This is a full-featured, responsive, and elegant e-commerce application built with PHP, Vanilla CSS, JavaScript, and MySQL designed specifically for selling fine jewellery (Gold, Silver, Platinum, Diamonds). 

The platform supports a robust customer-facing storefront and a fully integrated administration dashboard for managing inventory, orders, customers, and business reports.

## 🌟 Key Features

**Customer Features:**
*   **Modern Frontend:** High-quality, aesthetic UI tailored for luxury jewelry pieces, completely responsive for desktop and mobile.
*   **Product Browse & Filter:** Advanced sorting and dynamic AJAX filtering (by Material, Price Range, Category).
*   **AJAX Cart & Wishlist:** Seamlessly add products to cart and wishlist without frustrating page reloads. Button states dynamically reflect quantities natively upon load.
*   **User Accounts:** Registration, Login, Address Book management, and Profile Dashboard.
*   **Checkout Flow:** Comprehensive checkout mechanism including coupon application and order tracking.
*   **Ratings & Reviews:** Leave verified reviews and ratings directly on the product's page.

**Admin Dashboard (`/admin`):**
*   **Full Inventory Management:** Add, edit, and categorize products, manage stock levels, and assign rich images.
*   **Order Fulfillment:** View, manage, and update order statuses in real-time.
*   **Customer Management:** Track registered users.
*   **Sales Reports:** Review business statistics, track revenue, and monitor top products.
*   **Coupons Model:** Issue and manage conditional discount promotional codes.

## 💻 Tech Stack

*   **Frontend:** HTML5, modern Vanilla CSS (with Flexbox/Grid), and Vanilla JavaScript (AJAX/Fetch API).
*   **Backend:** Object-Oriented/Procedural PHP 8+.
*   **Database:** MySQL Server (managed via PDO for security).
*   **Design & UI Libraries:** FontAwesome (Icons), Google Fonts (Poppins), Toastify JS (Notifications), native IntersectionObserver for scroll-reveal animations.

## 🚀 Setup & Installation

Follow these steps to run the application securely on a local development server:

1. **Prerequisites:** Ensure you have a web server stack running locally, such as **XAMPP, WAMP, or MAMP** covering PHP & MySQL.
2. **Clone the Repository:** 
   Place the project folder within your local server's public directory (e.g., `C:\xampp\htdocs\jewellery\jewellery` or `/var/www/html/`).
3. **Database Configuration:**
   * Create a new empty database via phpMyAdmin or your MySQL CLI (e.g., named `jewellery_db`).
   * Import the provided initial SQL schema file located inside the `/database` directory into your new empty database.
   * Update the connection details inside `includes/db.php` if your credentials differ from the standard `root` default.
4. **Access the Platform:**
   * Open your web browser and navigate to `http://localhost/jewellery/jewellery/index.php`.
   * For the Admin Dashboard, navigate to `http://localhost/jewellery/jewellery/admin/login.php`.

## 🔐 Default Admin Credentials

If accessing a freshly seeded database instance, standard demo admin configurations are provided:
*   **Email:** `admin@jewels.com`
*   **Password:** `admin123`

*(Ensure you change these credentials prior to bringing the system into a production environment!)*

## 📂 Project Structure Snapshot
```
/jewellery
  |-- /admin            # Complete administration dashboard modules
  |-- /ajax             # Headless PHP handler scripts for handling AJAX calls (cart, wishlist)
  |-- /css              # Core styling 
  |-- /database         # Database schemas and seed files
  |-- /includes         # Global PHP headers, footers, database connections, helper functions
  |-- /js               # Interactive frontend JS logic
  |-- index.php         # Customer Homepage
  |-- shop.php          # Detailed multi-filter catalogue 
  |-- product.php       # Dynamic singular product display
  |-- checkout.php      # Customer transaction handling
  L-- ...
```

---
*Developed with a focus on premium aesthetics and stable shopping experiences.*

# Jheegu Cake - Online Cake Ordering System

A complete PHP-based web application for cake ordering and management with separate customer and admin interfaces.

##  Table of Contents
- [Features](#features)
- [Demo](#demo)
- [Technology Stack](#technology-stack)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Usage](#usage)
- [File Structure](#-ile-structure)
- [Screenshots](#screenshots)
- [Contributing](#-ontributing)
- [License](#license)

##  Features

### Customer Interface
- Browse cake catalog with images and descriptions
- Interactive order form with customization options
- Dynamic pricing based on cake weight (pounds)
- Egg/Eggless options available
- Custom message on cake feature
- Delivery date and time selection
- Multiple payment methods (COD, Esewa, Khalti)
- Order confirmation with unique order number
- Fully responsive design

### Admin Panel
- Secure admin authentication
- Comprehensive dashboard interface
- Product management (Add, Edit, Delete)
- Image upload for products
- Order management with status tracking
- Customer details with hover tooltips
- Order statistics and analytics
- Real-time status updates
- Mobile-friendly admin interface

##  Demo

### Customer Flow
1. Browse available cakes on homepage
2. Click "Order Now" on desired cake
3. Customize cake (weight, egg option, message)
4. Fill customer details and delivery information
5. Receive order confirmation

### Admin Flow
1. Login to admin panel
2. Manage products and view orders
3. Update order status as they progress
4. Track customer information and delivery details

##  Technology Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript
- **Styling**: Tailwind CSS
- **Server**: Apache/Nginx with PHP support
- **File Handling**: PHP file upload system

##  Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- Git

### Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/jheegu-cake.git
   cd jheegu-cake
   ```

2. **Set up web server**
   - Place the project in your web server directory (e.g., `htdocs`, `www`)
   - Ensure PHP is enabled

3. **Configure database connection**
   - Update database credentials in:
     - `admin/db-conn.php`
     - `frontend/db-conn.php`
   ```php
   $conn = mysqli_connect("localhost", "your_username", "your_password", "jheegu-cake");
   ```

4. **Set file permissions**
   ```bash
   chmod 755 admin/dashboard/product-uploads/
   ```

5. **Access the application**
   - Customer Interface: `http://localhost/jheegu-cake/frontend/`
   - Admin Panel: `http://localhost/jheegu-cake/admin/auth/login.php`

## 🗄️ Database Setup

Create the MySQL database and tables:

```sql
CREATE DATABASE `jheegu-cake`;
USE `jheegu-cake`;

-- Admin table
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

-- Menu table
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image-url` varchar(255) DEFAULT NULL,
  `item-name` varchar(255) NOT NULL,
  `description` text,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

-- Order details table
CREATE TABLE `orderdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderNo` varchar(50) NOT NULL,
  `pound` int(11) NOT NULL,
  `eggOption` varchar(20) NOT NULL,
  `cakeMessage` text,
  `cakeName` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

-- Customer details table
CREATE TABLE `customerdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_no` varchar(50) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `delivery_date` datetime NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
);

-- Order status table
CREATE TABLE `order_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(50) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `cake_name` varchar(255) NOT NULL,
  `pound` int(11) NOT NULL,
  `egg_option` varchar(20) NOT NULL,
  `delivery_date` datetime NOT NULL,
  `cake_message` text,
  `status` enum('pending','processing','done','cancelled') DEFAULT 'pending',
  PRIMARY KEY (`id`)
);

-- Insert default admin user
INSERT INTO `admin` (`email`, `password`) VALUES ('admin@jheegucake.com', 'admin123');
```

##  Usage

### For Customers
1. Visit the homepage to browse available cakes
2. Click on any cake to view details and place an order
3. Fill out the two-step order form:
   - **Step 1**: Cake customization (weight, egg option, message)
   - **Step 2**: Personal and delivery details
4. Submit the order and receive confirmation

### For Administrators
1. Access admin panel: `/admin/auth/login.php`
2. **Default credentials**: 
   - Email: `admin@jheegucake.com`
   - Password: `admin123`
3. **Dashboard Features**:
   - **Menu Management**: Add, edit, or delete cake products
   - **Order Management**: View and update order statuses
   - **Customer Details**: Access customer information and delivery details

## 📁 File Structure

```
jheegu-cake/
├── admin/
│   ├── auth/
│   │   ├── login.php              # Admin login page
│   │   ├── login-handle.php       # Login processing
│   │   ├── logout-handle.php      # Logout handling
│   │   └── delete-product.php     # Product delete
│   ├── dashboard/
│   │   ├── dashboard.php          # Main admin interface
│   │   ├── add-product.php        # Add product form
│   │   ├── add-product-handle.php # Add product processing
│   │   ├── edit-product.php       # Edit product page
│   │   ├── menu.php              # Product management
│   │   ├── order/
│   │   │   ├── orders.php         # Order management
│   │   │   ├── order-handle.php   # Order processing
│   │   │   └── order-success.php  # Order confirmation
│   │   └── product-uploads/       # Uploaded images
│   ├── src/
│   │   └── output.css            # Compiled Tailwind CSS
│   └── db-conn.php               # Database connection
├── frontend/
│   ├── index.php                 # Customer homepage
│   ├── menu.php                  # Product display component
│   ├── src/
│   │   ├── input.css             # Tailwind source
│   │   └── output.css            # Compiled CSS
│   └── db-conn.php               # Database connection
└── README.md
```



### Customer Actions
- `GET /frontend/index.php` - Homepage with menu
- `POST /admin/dashboard/order/order-handle.php` - Submit order

### Admin Actions
- `POST /admin/auth/login-handle.php` - Admin login
- `GET /admin/dashboard/dashboard.php` - Admin dashboard
- `POST /admin/dashboard/add-product-handle.php` - Add product
- `GET /admin/dashboard/edit-product.php` - Edit product
- `GET /admin/auth/delete-product.php` - Delete product
- `POST /admin/dashboard/order/orders.php` - Update order status

##  Screenshots

![alt text](screenshotsss/home.png)
![alt text](screenshotsss/home2.png)
![alt text](screenshotsss/home3.png)
![alt text](screenshotsss/admin1.png)
![alt text](screenshotsss/admin2.png)
![alt text](screenshotsss/admin3.png)



### Customer Interface
- Clean, modern homepage with cake gallery
- Interactive order form with real-time price updates
- Mobile-responsive design

### Admin Panel
- Secure login interface
- Comprehensive dashboard with sidebar navigation
- Product management with image upload
- Order tracking with status updates

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request


## Security Features

- **SQL Injection Protection**: Prepared statements used throughout
- **Session Management**: Secure admin authentication
- **File Upload Security**: Image validation and secure storage
- **Input Validation**: Form data sanitization

## Known Issues & Limitations

- Admin passwords are stored in plain text (recommend implementing password hashing)
- No email notifications for order confirmations
- Limited payment gateway integration
- No customer registration system

##  Future Enhancements

- [ ] Password hashing for admin accounts
- [ ] Email notification system
- [ ] Customer registration and login
- [ ] Payment gateway integration
- [ ] Order tracking for customers
- [ ] Inventory management
- [ ] Sales analytics and reporting
- [ ] Multi-language support

##  Support

For support and questions:
- **Email**: jheegucake@example.com
- **Phone**: +977 9808823698
- **Address**: Gurjudhara, Kathmandu, Nepal

##  License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

##  Author

**Jheegu Cake Team**
- Custom cake ordering system for traditional and modern celebrations
- Built with love in Kathmandu, Nepal

---

** If you found this project helpful, please give it a star!**

# Tours and Travel Management System

A full-featured web application built with PHP, MySQL, HTML, and CSS for managing and recommending travel packages. It allows users to register, book tours, leave reviews, and explore places interactively on a map.

## Features

- User Registration and Login
- Booking System with dynamic pricing
- Package Filtering by Category and Subcategory
- Review and Rating system per travel package
- Personalized Recommendations based on user preferences
- "Explore More" with interactive maps for nearby attractions, hotels, and restaurants
- Contact and Inquiry system
- Clean and responsive UI

## How It Works

### 1. User Registration and Login
- New users can register using the `register.php` form.
- Passwords are stored securely using PHP hashing.
- Only logged-in users can book packages or leave reviews.

### 2. Travel Package Display
- All packages are fetched from the database and displayed with details.
- Users can filter packages by category or subcategory.

### 3. Booking a Package
- Users click "Book Now" on any package.
- Booking form pre-fills the selected package and calculates the total price based on adults and children.
- Booking is saved in the `booking` table and linked to the user.

### 4. User Preferences and Recommendations
- Users set preferences (budget and category) via `set_preference.php`.
- Recommended packages are shown on the home page based on these preferences.

### 5. Reviews and Ratings
- Users can review packages they’ve booked.
- Reviews are stored in the `reviews` table and shown under each package.

### 6. Explore More (Map Feature)
- Clicking "Explore More" on a package opens `place_explorer.php`.
- Using Leaflet.js and Overpass API, it shows:
  - Top 5 nearby attractions
  - Top 5 nearby restaurants
  - 1 nearby hotel
- Clicking any map marker displays place details and travel tips.

### 7. Contact and Enquiries
- Users can submit general queries via `contact.php`.
- Data is saved to the `contact_us` or `enquiry` table.

## Project Structure

project-root/
├── images/ # Image assets
├── includes/ # Shared files like header, footer, db connection
├── pages/ # All dynamic pages (home.php, login.php, etc.)
├── videos/ # Video assets (optional)
├── index.php # Main routing file
└── README.md # Project documentation


## Technologies Used

- PHP (Backend)
- MySQL (Database)
- HTML, CSS (Frontend)
- JavaScript (Dynamic interaction)
- Leaflet.js and Overpass API (Map-based features)
- OpenStreetMap (Map data)

## How to Run Locally

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/tours-and-travel.git
   cd tours-and-travel
2.Install XAMPP/WAMP and place the folder inside htdocs or www.

3.Create a MySQL database (e.g., travel_db) and import the provided SQL file.

4.Configure the database connection in includes/db_connect.php:
$conn = new mysqli("localhost", "root", "", "travel_db");

5.Open your browser:
http://localhost/tours-and-travel/index.php

Future Enhancements
* Admin dashboard for managing packages and users

* Payment integration (Razorpay/Stripe)

* Booking confirmation emails

* Multi-language support

* AI-based smart recommendations

Author
Harini Kannan
Junior Data Analyst and Web Developer
Skilled in Python, SQL, and full-stack web development
LinkedIn:www.linkedin.com/in/harinikannan4114
 

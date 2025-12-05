🚀 Laravel User Management CRUD (API + Frontend)

This project is a simple and modern User Management System built with Laravel, using:

✅ API-based CRUD (Create, Read, Update, Delete)
✅ TailwindCSS frontend
✅ Toastify notifications
✅ Image upload with storage
✅ DataTables for user listing
✅ Fetch API for AJAX requests
✅ Clean UI for Register, Edit, and User Details pages

📌 Features
👤 User Registration

Create users using /api/users

Upload profile image

Hash password before saving

Frontend validation + toast notifications

📄 User Listing

Display all users using DataTables

Shows image, name, email, phone

Edit and Delete buttons

Instant reload after deleting

✏️ User Edit

Update name, phone, image

Email stays locked (not editable)

Live image preview

Redirect after successful update

👀 User Details Page

Show full user details

Edit button

Delete button

Back button

🗄 API Endpoints Used
Method	Endpoint	Description
POST	/api/users	Create user
GET	/api/users	Get all users
GET	/api/users/{id}	Get single user
PUT	/api/users/{id}	Update user
DELETE	/api/users/{id}	Delete user
🧱 Project Structure
Frontend Views

Located in:

resources/views/auth/register.blade.php
resources/views/users/index.blade.php
resources/views/users/show.blade.php
resources/views/users/edit.blade.php

User API Controller
app/Http/Controllers/User/UserController.php


Handles:

store()

index()

show()

update()

destroy()

Routing
web.php — Blade views only
api.php — User CRUD operations
📦 Installation
1️⃣ Clone repository
git clone https://github.com/jbc007442/interview.git
cd interview

2️⃣ Install dependencies
composer install

3️⃣ Setup environment
cp .env.example .env
php artisan key:generate

4️⃣ Run migrations
php artisan migrate

5️⃣ Link storage (required for image upload)
php artisan storage:link

6️⃣ Start server
php artisan serve

🖼 Image Upload Feature

Images are stored in:

storage/app/public/users/


Accessible via URL after running:

php artisan storage:link

📊 Users Table Page

Built using:

jQuery 3.7

DataTables 1.13

Tailwind CSS

🎨 UI Technology
Feature	Tech
Styling	TailwindCSS CDN
Alerts	Toastify.js
Table	DataTables
AJAX CRUD	Fetch API
🧪 Future Improvements (Optional)



Add pagination in API

Add search & filters in table


📜 License

This project is open-source and free to use.

If you want I can:

✅ Add project screenshots to README
✅ Add badges (PHP, Laravel, Tailwind)
✅ Format with emojis and better styling
✅ Add demo video section

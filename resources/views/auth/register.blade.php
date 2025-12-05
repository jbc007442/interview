<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind Register Form</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Toastify CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>

<body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">Register</h2>

        <form id="registerForm" class="space-y-4">

            <!-- Name -->
            <div>
                <label class="block text-sm font-medium mb-1">Name</label>
                <input type="text" id="name"
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300"
                    placeholder="Enter your name">
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" id="email"
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300"
                    placeholder="Enter your email">
            </div>

            <!-- Phone -->
            <div>
                <label class="block text-sm font-medium mb-1">Phone</label>
                <input type="tel" id="phone"
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300"
                    placeholder="Enter phone number">
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password" id="password"
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300"
                    placeholder="Enter password">
            </div>

            <!-- Image Upload -->
            <div>
                <label class="block text-sm font-medium mb-1">Profile Image</label>
                <input type="file" id="image" accept="image/*"
                    class="w-full border rounded-lg px-4 py-2 bg-gray-50">
            </div>

            <!-- Submit -->
            <button id="submitBtn" type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg text-lg font-semibold">
                Register
            </button>
        </form>
    </div>

    <!-- Toastify JS -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        const form = document.getElementById("registerForm");
        const submitBtn = document.getElementById("submitBtn");

        form.addEventListener("submit", async function(e) {
            e.preventDefault();

            let name = document.getElementById("name").value.trim();
            let email = document.getElementById("email").value.trim();
            let phone = document.getElementById("phone").value.trim();
            let password = document.getElementById("password").value.trim();
            let image = document.getElementById("image").files[0];

            if (!name || !email || !phone || !password || !image) {
                return showToast("All fields are required!", "#DC2626");
            }

            let formData = new FormData();
            formData.append("name", name);
            formData.append("email", email);
            formData.append("phone", phone);
            formData.append("password", password);
            formData.append("image", image);

            submitBtn.disabled = true;
            submitBtn.innerText = "Processing...";

            try {
                let response = await fetch("/api/users", {
                    method: "POST",
                    body: formData
                });

                // Read backend response as text
                let raw = await response.text();
                console.log("RAW RESPONSE:", raw);
                console.log("RAW SERVER RESPONSE:", raw);

                // Try converting to JSON
                let data;
                try {
                    data = JSON.parse(raw);
                } catch (error) {
                    console.error("FAILED TO PARSE JSON — Backend returned HTML");
                    return showToast("Server Error: Invalid JSON response", "#DC2626");
                }


                if (!response.ok) {
                    let message = data.message || "Registration failed";

                    // Show first validation error if available
                    if (data.errors) {
                        const firstError = Object.values(data.errors)[0][0];
                        message = firstError;
                    }

                    throw new Error(message);
                }

                showToast("Registration Successful!", "#16A34A");

                // Redirect using backend response
                if (data.redirect) {
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1000);
                }

            } catch (error) {
                showToast(error.message, "#DC2626");
            }

            submitBtn.disabled = false;
            submitBtn.innerText = "Register";
        });

        function showToast(text, color) {
            Toastify({
                text,
                backgroundColor: color,
                duration: 3000
            }).showToast();
        }
    </script>

</body>

</html>

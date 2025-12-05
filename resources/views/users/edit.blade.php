<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Toastify -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex justify-center items-center">

    <div class="bg-white w-full max-w-md p-8 rounded-xl shadow-md relative">

        <!-- 🔙 BACK BUTTON -->
        <a href="/users" 
           class="absolute left-4 top-4 bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-1 rounded-md text-sm">
            ← Back
        </a>

        <h2 class="text-2xl font-bold text-center mb-6 mt-6">Edit User</h2>

        <form id="editForm" enctype="multipart/form-data">

            <!-- Image Preview -->
            <div class="text-center mb-4">
                <img id="previewImage" class="w-24 h-24 rounded-full mx-auto object-cover shadow" src="" alt="">
            </div>

            <div class="space-y-4">

                <!-- Name -->
                <div>
                    <label class="block mb-1 text-sm font-medium">Name</label>
                    <input id="name" type="text" class="w-full border px-4 py-2 rounded-lg"
                        placeholder="Enter name">
                </div>

                <!-- Email (disabled) -->
                <div>
                    <label class="block mb-1 text-sm font-medium">Email</label>
                    <input id="email" type="email" 
                        class="w-full border px-4 py-2 rounded-lg bg-gray-100 cursor-not-allowed" disabled>
                </div>

                <!-- Phone -->
                <div>
                    <label class="block mb-1 text-sm font-medium">Phone</label>
                    <input id="phone" type="tel" 
                        class="w-full border px-4 py-2 rounded-lg" placeholder="Enter phone number">
                </div>

                <!-- Upload Image -->
                <div>
                    <label class="block mb-1 text-sm font-medium">Change Image</label>
                    <input id="image" type="file" accept="image/*"
                        class="w-full border rounded-lg px-4 py-2 bg-gray-50">
                </div>

            </div>

            <button id="submitBtn" type="submit" 
                class="mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg text-lg">
                Update User
            </button>
        </form>
    </div>

    <!-- Toastify -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        const userId = "{{ $id }}";

        // Fetch user and fill data
        document.addEventListener("DOMContentLoaded", async () => {
            try {
                const response = await fetch(`/api/users/${userId}`);
                const data = await response.json();

                if (!data.status) throw new Error("User not found");

                const user = data.user;

                document.getElementById("name").value = user.name;
                document.getElementById("email").value = user.email;
                document.getElementById("phone").value = user.phone ?? "";

                document.getElementById("previewImage").src = user.image
                    ? `/storage/${user.image}`
                    : "https://via.placeholder.com/150";

            } catch (error) {
                Toastify({
                    text: error.message,
                    style: { background: "#DC2626" },
                    duration: 3000
                }).showToast();
            }
        });

        // Live image preview
        document.getElementById("image").addEventListener("change", function () {
            const file = this.files[0];
            if (file) {
                document.getElementById("previewImage").src = URL.createObjectURL(file);
            }
        });

        // Handle update
        document.getElementById("editForm").addEventListener("submit", async function (e) {
            e.preventDefault();

            const submitBtn = document.getElementById("submitBtn");
            submitBtn.disabled = true;
            submitBtn.innerText = "Updating...";

            const formData = new FormData();
            formData.append("_method", "PUT");
            formData.append("name", document.getElementById("name").value);
            formData.append("phone", document.getElementById("phone").value);

            const imageFile = document.getElementById("image").files[0];
            if (imageFile) formData.append("image", imageFile);

            try {
                const response = await fetch(`/api/users/${userId}`, {
                    method: "POST",
                    body: formData
                });

                const data = await response.json();

                if (!response.ok) {
                    let msg = data.message || "Update failed";

                    if (data.errors) {
                        msg = Object.values(data.errors)[0][0];
                    }

                    throw new Error(msg);
                }

                Toastify({
                    text: data.message,
                    style: { background: "#16A34A" },
                    duration: 3000
                }).showToast();

                if (data.redirect) {
                    setTimeout(() => window.location.href = data.redirect, 1000);
                }

            } catch (error) {
                Toastify({
                    text: error.message,
                    style: { background: "#DC2626" },
                    duration: 3000
                }).showToast();
            }

            submitBtn.disabled = false;
            submitBtn.innerText = "Update User";
        });
    </script>

</body>
</html>

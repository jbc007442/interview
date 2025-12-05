<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Toastify -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex justify-center items-center">

    <div class="bg-white w-full max-w-md p-6 rounded-xl shadow-lg relative">

        <!-- 🔙 BACK BUTTON -->
        <a href="/users" 
           class="absolute left-4 top-4 bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-1 rounded-md text-sm">
            ← Back
        </a>

        <h1 class="text-2xl font-bold text-center mb-6 mt-6">User Details</h1>

        <div id="userCard" class="text-center hidden">
            
            <!-- Image -->
            <img id="userImage" class="w-28 h-28 rounded-full mx-auto shadow mb-4 object-cover">

            <!-- Name -->
            <h2 id="userName" class="text-xl font-semibold"></h2>

            <!-- Email -->
            <p id="userEmail" class="text-gray-600"></p>

            <!-- Phone -->
            <p id="userPhone" class="text-gray-700 mt-2"></p>

            <!-- Joined -->
            <p id="createdAt" class="text-gray-500 text-sm mt-1"></p>

            <!-- Buttons -->
            <div class="flex justify-center gap-3 mt-5">
                <a id="editBtn" href="#" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Edit
                </a>

                <button onclick="deleteUser()" 
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                    Delete
                </button>
            </div>
        </div>

        <p id="loadingText" class="text-center text-gray-600">Loading user...</p>

    </div>

    <!-- Toastify -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        const userId = "{{ $id }}";

        document.addEventListener("DOMContentLoaded", async () => {
            try {
                const res = await fetch(`/api/users/${userId}`);
                const data = await res.json();

                if (!data.status) throw new Error("User not found.");

                const user = data.user;

                document.getElementById("loadingText").style.display = "none";
                document.getElementById("userCard").classList.remove("hidden");

                document.getElementById("userName").innerText = user.name;
                document.getElementById("userEmail").innerText = user.email;
                document.getElementById("userPhone").innerText = user.phone ?? "No phone added";
                document.getElementById("createdAt").innerText =
                    "Joined: " + new Date(user.created_at).toLocaleDateString();

                document.getElementById("userImage").src = user.image
                    ? `/storage/${user.image}`
                    : "https://via.placeholder.com/150";

                document.getElementById("editBtn").href = `/users/${userId}/edit`;

            } catch (error) {
                document.getElementById("loadingText").innerText = error.message;
            }
        });

        async function deleteUser() {
            if (!confirm("Are you sure you want to delete this user?")) return;

            const res = await fetch(`/api/users/${userId}`, { method: "DELETE" });
            const data = await res.json();

            if (res.ok) {
                Toastify({
                    text: "User deleted successfully!",
                    style: { background: "#DC2626" }
                }).showToast();

                setTimeout(() => window.location.href = "/users", 1000);
            } else {
                Toastify({
                    text: data.message || "Delete failed",
                    style: { background: "#DC2626" }
                }).showToast();
            }
        }
    </script>

</body>
</html>

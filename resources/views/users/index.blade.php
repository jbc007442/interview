<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <!-- Toastify -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
</head>
<body class="bg-gray-100">

    <div class="max-w-5xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">

        <!-- Header + Back Button -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">All Users</h1>

            <a href="/"
                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                ⬅ Back
            </a>
        </div>

        <table id="usersTable" class="display min-w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="userData"></tbody>
        </table>

    </div>

    <!-- Toastify -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", loadUsers);

        async function loadUsers() {
            let tableBody = document.getElementById("userData");

            try {
                let response = await fetch("/api/users");
                let res = await response.json();
                let users = res.users;

                tableBody.innerHTML = "";

                users.forEach(user => {
                    tableBody.innerHTML += `
                        <tr>
                            <td><img src="/storage/${user.image}" class="w-12 h-12 rounded-lg object-cover"></td>
                            <td>${user.name}</td>
                            <td>${user.email}</td>
                            <td>${user.phone}</td>
                            <td class="flex gap-2 justify-center">

                                <!-- View User -->
                                <a href="/users/${user.id}"
                                   class="bg-green-500 text-white px-3 py-1 rounded-md hover:bg-green-600">
                                    View
                                </a>

                                <!-- Edit User -->
                                <a href="/users/${user.id}/edit"
                                   class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600">
                                    Edit
                                </a>

                                <!-- Delete User -->
                                <button onclick="deleteUser(${user.id})"
                                        class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    `;
                });

                if (!$.fn.DataTable.isDataTable('#usersTable')) {
                    $('#usersTable').DataTable();
                }

            } catch (error) {
                console.error(error);
            }
        }

        async function deleteUser(id) {
            if (!confirm("Are you sure you want to delete this user?")) return;

            try {
                let response = await fetch(`/api/users/${id}`, {
                    method: "DELETE"
                });

                let result = await response.json();

                if (response.ok) {
                    Toastify({
                        text: "User deleted successfully!",
                        style: { background: "#DC2626" }
                    }).showToast();

                    loadUsers();
                } else {
                    Toastify({
                        text: result.message || "Delete failed",
                        style: { background: "#DC2626" }
                    }).showToast();
                }

            } catch (error) {
                console.error(error);
            }
        }
    </script>

</body>
</html>

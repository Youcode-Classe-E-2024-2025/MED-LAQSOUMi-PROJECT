<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Kanban Project</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <h1 class="text-xl font-bold text-gray-800">Kanban Project</h1>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <button id="logoutBtn" class="ml-4 px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Logout
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Your Projects</h2>
                <div id="projectList" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Projects will be dynamically added here -->
                </div>
                <button id="newProjectBtn" class="mt-4 px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    New Project
                </button>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetchProjects();

            document.getElementById('logoutBtn').addEventListener('click', logout);
            document.getElementById('newProjectBtn').addEventListener('click', showNewProjectForm);
        });

        async function fetchProjects() {
            try {
                const response = await fetch('../index.php?action=getUserProjects');
                const data = await response.json();
                if (data.success) {
                    renderProjects(data.projects);
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while fetching projects.');
            }
        }

        function renderProjects(projects) {
            const projectList = document.getElementById('projectList');
            projectList.innerHTML = '';
            projects.forEach(project => {
                const projectElement = document.createElement('div');
                projectElement.className = 'bg-white overflow-hidden shadow rounded-lg';
                projectElement.innerHTML = `
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium text-gray-900">${project.name}</h3>
                        <p class="mt-1 text-sm text-gray-600">${project.description}</p>
                        <a href="/project/${project.id}" class="mt-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            View Project
                        </a>
                    </div>
                `;
                projectList.appendChild(projectElement);
            });
        }

        async function logout() {
            try {
                const response = await fetch('../index.php?action=logout');
                const data = await response.json();
                if (data.success) {
                    window.location.href = '../index.php';
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while logging out.');
            }
        }

        function showNewProjectForm() {
            // Implement a modal or form to create a new project
            alert('New Project form not implemented yet.');
        }
    </script>
</body>
</html>


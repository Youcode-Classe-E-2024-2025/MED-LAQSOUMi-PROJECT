<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Responsive Kanban board for team project management">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+PhagsPa&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>KANBAN</title>
</head>
<body class="font-poppins bg-gradient-to-tr from-gray-800 via-gray-900 to-black min-h-screen text-white">
    <div class="container mx-auto px-4 py-8">
        <header class="bg-gray-800 bg-opacity-75 rounded-lg shadow-md p-4 mb-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="flex items-center mb-4 md:mb-0">
                    <svg class="w-8 h-8 text-indigo-400 stroke-current mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                    </svg>
                    <h1 class="text-2xl font-bold text-gray-200">Team Project Board</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <input class="px-4 py-2 rounded-full bg-gray-700 text-white focus:outline-none focus:ring focus:border-blue-300" type="search" placeholder="Search for anything…">
                    <button class="p-2 rounded-full bg-gray-700 hover:bg-gray-600 focus:outline-none focus:ring focus:border-blue-300">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
            </div>
        </header>

        <main class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <section class="bg-gray-800 rounded-lg shadow-md p-4">
                <h2 class="text-lg font-semibold mb-4 flex justify-between items-center">
                    <span>TODO</span>
                    <span class="text-sm font-normal bg-blue-900 text-blue-300 py-1 px-3 rounded-full">3</span>
                </h2>
                <div class="space-y-4">
                    <div class="bg-gray-700 border border-gray-600 rounded-lg p-4 shadow-sm">
                        <div class="flex justify-between items-start mb-2">
                            <span class="px-2 py-1 text-xs font-semibold bg-pink-900 text-pink-300 rounded-full">Design</span>
                            <button class="text-gray-400 hover:text-gray-200">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                            </button>
                        </div>
                        <h3 class="font-medium mb-2">Create wireframe for homepage</h3>
                        <div class="flex items-center text-sm text-gray-400">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                            <span>Dec 12</span>
                        </div>
                    </div>
                    <!-- More TODO tasks -->
                </div>
            </section>

            <section class="bg-gray-800 rounded-lg shadow-md p-4">
                <h2 class="text-lg font-semibold mb-4 flex justify-between items-center">
                    <span>DOING</span>
                    <span class="text-sm font-normal bg-yellow-900 text-yellow-300 py-1 px-3 rounded-full">2</span>
                </h2>
                <div class="space-y-4">
                    <!-- DOING tasks -->
                </div>
            </section>

            <section class="bg-gray-800 rounded-lg shadow-md p-4">
                <h2 class="text-lg font-semibold mb-4 flex justify-between items-center">
                    <span>REVIEW</span>
                    <span class="text-sm font-normal bg-purple-900 text-purple-300 py-1 px-3 rounded-full">2</span>
                </h2>
                <div class="space-y-4">
                    <!-- REVIEW tasks -->
                </div>
            </section>

            <section class="bg-gray-800 rounded-lg shadow-md p-4">
                <h2 class="text-lg font-semibold mb-4 flex justify-between items-center">
                    <span>DONE</span>
                    <span class="text-sm font-normal bg-green-900 text-green-300 py-1 px-3 rounded-full">1</span>
                </h2>
                <div class="space-y-4">
                    <!-- DONE tasks -->
                </div>
            </section>
        </main>
    </div>
    <script src="/assets/js/main.js"></script>
</body>
</html>
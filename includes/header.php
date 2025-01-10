<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskflow Manager - Boost Your Productivity</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2762cf',
                        secondary: '#10B981',
                        accent: '#8B5CF6',
                    }
                }
            },
            darkMode: 'class',
        }
    </script> -->
</head>
<body class="flex flex-col m-auto min-h-screen justify-between bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-300">
    <header class="bg-white dark:bg-gray-800 shadow-md relative w-full z-10 transition-colors duration-300">
        <nav class="container mx-auto px-6 py-3">
            <div class="flex justify-between items-center">
                <a href="../index.php" class="text-2xl font-bold text-primary">Taskflow Manager</a>
                <div class="hidden md:flex space-x-4">
                    <a href="#features" class="text-gray-600 dark:text-gray-300 hover:text-primary transition-colors duration-300">Features</a>
                    <a href="#about" class="text-gray-600 dark:text-gray-300 hover:text-primary transition-colors duration-300">About</a>
                    <a href="#contact" class="text-gray-600 dark:text-gray-300 hover:text-primary transition-colors duration-300">Contact</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="./login.php" class=" text-gray-600 dark:text-gray-300 hover:text-primary transition-colors duration-300">Login</a>
                    <a href="./register.php" class="bg-primary text-white p-1 rounded hover:bg-blue-600 transition-colors duration-300">Sign Up</a>
                    <button id="darkModeToggle" class="text-gray-600 dark:text-gray-300 hover:text-primary transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>
                </div>
            </div>
        </nav>
    </header>
    <main class="flex-1 content-center items-center">
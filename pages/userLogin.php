<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ecomomentum</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-xl shadow-lg w-96">
        <h1 class="text-3xl font-bold mb-6 text-green-600 text-center">Ecomomentum</h1>

        <!-- Login Form -->
        <form method="POST" action="user_login.php" class="space-y-4">
            <!-- Error Message -->
            <?php if(isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <!-- Email Input -->
            <div>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    required 
                    placeholder="Email" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                >
            </div>

            <!-- Password Input -->
            <div>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    required 
                    placeholder="Password" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                >
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700 transition duration-300"
            >
                Login
            </button>
        </form>

        <!-- Links for Forgot Password and Sign Up -->
        <div class="mt-4 text-center">
            <a href="#" class="text-green-600 hover:underline">Forgot Password?</a>
            <p class="mt-2 text-sm text-gray-600">
                Don't have an account? 
                <a href="#" class="text-green-600 hover:underline">Sign Up</a>
            </p>
        </div>
    </div>
</body>
</html>

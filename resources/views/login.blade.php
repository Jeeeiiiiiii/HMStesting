<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  @vite('resources/css/app.css')
  @vite('resources/js/app.js')
  
  <!-- Google Fonts (optional for aesthetics) -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  
  <!-- Custom CSS -->
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: url('/img.png') no-repeat center center fixed; /* Background image */
      background-size: cover; /* Cover the entire viewport */
    }

    /* Animation for success and error messages */
    .fade-in {
      animation: fadeIn ease 0.5s;
    }

    @keyframes fadeIn {
      0% { opacity: 0; }
      100% { opacity: 1; }
    }

    /* Spinner Style */
    .loading-spinner {
      border-top-color: transparent;
      border-right-color: rgba(29, 78, 216, 0.75);
      border-left-color: rgba(29, 78, 216, 0.75);
    }
  </style>
</head>
<body class="font-sans antialiased min-h-screen flex justify-center items-center">

  <!-- Loading Spinner -->
  <div id="loading-spinner" class="hidden fixed inset-0 flex items-center justify-center bg-white bg-opacity-75 z-50">
    <div class="w-16 h-16 border-4 border-blue-500 border-t-transparent rounded-full animate-spin loading-spinner"></div>
  </div>

  <!-- Login Form -->
  <div class="bg-white shadow-lg rounded-lg p-6 sm:p-8 md:p-10 lg:p-12 max-w-md w-full space-y-6 transform transition-all duration-300 hover:scale-105 mx-8 sm:mx-8 md:mx-8 lg:mx-10">
    
    <!-- Success Message -->
    @if(session()->has('success'))
      <div class="fade-in bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
      </div>
    @endif

    <!-- Error Message -->
    @if(session()->has('error'))
      <div class="fade-in bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
      </div>
    @endif

    <!-- Form Header -->
    <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 text-center">Login</h2>
    <p class="text-xs sm:text-sm text-gray-500 text-center">Please login to your account</p>

    <!-- Login Form -->
    <form method="POST" action="{{ route('login.action') }}" class="space-y-4">
      @csrf

      <!-- Email Field -->
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input id="email" class="block mt-1 w-full rounded-md border shadow-sm px-3 py-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Your email" />
      </div>

      <!-- Password Field -->
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input id="password" class="block mt-1 w-full rounded-md border shadow-sm px-3 py-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" type="password" name="password" required autocomplete="current-password" placeholder="Your password" />
      </div>

      <!-- Submit and Forgot Password Link -->
      <div class="flex flex-col items-center justify-center mt-4 space-y-4">
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md font-medium shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-150">
          Log in
        </button>
      </div>

      <!-- Forgot Password Link -->
      <div>
        <a href="{{ route('forget.password.get') }}" class="text-sm text-indigo-600 hover:text-indigo-500">Forgot your password?</a>
      </div>

    </form>
  </div>

  <!-- Optional JavaScript for Handling Loading Spinner -->
  <script>
    const form = document.querySelector('form');
    const loadingSpinner = document.getElementById('loading-spinner');
    
    form.addEventListener('submit', () => {
      loadingSpinner.classList.remove('hidden');
    });
  </script>

</body>
</html>

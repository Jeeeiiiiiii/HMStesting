<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
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

      <!-- Reset Password Form -->
      <div class="bg-white shadow-lg rounded-lg p-6 sm:p-8 md:p-10 lg:p-12 max-w-md w-full space-y-6 transform transition-all duration-300 hover:scale-105 mx-8 sm:mx-8 md:mx-8 lg:mx-10">
          <!-- Form Header -->
          <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 text-center">Reset Password</h2>
          <p class="text-xs sm:text-sm text-gray-500 text-center">Enter your email to receive a password reset link</p>

          <form action="{{ route('forget.password.post') }}" method="POST" class="space-y-4">
            @csrf
                <div class="form-group">
                    <label for="email_address" class="block text-sm font-medium text-gray-700">E-Mail Address</label>
                    <input type="text" id="email_address" class="block mt-1 w-full rounded-md border shadow-sm px-3 py-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" name="email" required autofocus>
                    @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="flex items-center justify-center mt-4 space-y-4">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md font-medium shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-150">
                    Send Password Reset Link
                    </button>
                </div>
          </form>
          <div>
            <a href="{{ route('login') }}" class="text-md text-indigo-600 hover:text-indigo-500">Login</a>
          </div>
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

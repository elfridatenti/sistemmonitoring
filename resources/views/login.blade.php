<!DOCTYPE html>
<html>
<head>
    <title>Login - PT Volex</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a237e 0%, #283593 25%, #3949ab 50%, #5c6bc0 75%, #7986cb 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            overflow: hidden;
        }
        
        /* Abstract background elements */
        .bg-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.05;
            background-color: #ffffff;
        }
        
        .shape-1 {
            width: 600px;
            height: 600px;
            top: -200px;
            right: -200px;
        }
        
        .shape-2 {
            width: 400px;
            height: 400px;
            bottom: -150px;
            left: -150px;
        }
        
        .shape-3 {
            width: 300px;
            height: 300px;
            top: 60%;
            right: 10%;
        }
        
        .login-container {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .form-container {
            background-color: rgba(255, 255, 255, 0.98);
            border-radius: 0.7rem;
            width: 440px;
            max-width: 90%;
            padding: 2.5rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
            transition: all 0.3s ease;
            position: relative;
            z-index: 10;
            backdrop-filter: blur(10px);
        }
        
        .form-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        
        .logo-circle {
            margin: 0 auto;
            height: 6rem;
            width: 6rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            overflow: hidden;
            background-color: #ffffff;
            border: 3px solid #e5e7eb;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.12);
            transition: all 0.3s ease;
        }
        
        .logo-circle:hover {
            border-color: #3949ab;
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        
        .app-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: #1a237e;
            letter-spacing: 0.05em;
            margin-top: 1rem;
            line-height: 1.5;
        }
        
        .company-name {
            font-size: 1.1rem;
            font-weight: 550;
            color: #5c6bc0;
            letter-spacing: 0.025em;
            margin-top: 0.25rem;
        }
        
        .input-container {
            position: relative;
            border: 1px solid #e2e8f0;
            margin-bottom: 1.75rem;
            background-color: #f8fafc;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .input-container:focus-within {
            box-shadow: 0 0 0 3px rgba(57, 73, 171, 0.25);
            background-color: #ffffff;
            border-color: #3949ab;
        }
        
        .input-icon-wrapper {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            width: 3.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            transition: all 0.3s ease;
            background-color: rgba(241, 245, 249, 0.5);
            border-right: 1px solid #e2e8f0;
        }
        
        .input-container:focus-within .input-icon-wrapper {
            color: #3949ab;
            background-color: #eff6ff;
            border-right-color: #c7d2fe;
        }
        
        .input-field {
            width: 100%;
            padding: 1rem 1.25rem 1rem 3.75rem;
            border: none;
            font-size: 1rem;
            background-color: transparent;
            transition: all 0.3s ease;
            color: #1e293b;
        }
        
        .input-field::placeholder {
            color: #94a3b8;
        }
        
        .input-field:focus {
            outline: none;
        }
        
        .password-toggle {
            position: absolute;
            right: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            cursor: pointer;
            transition: color 0.2s ease;
        }
        
        .input-container:focus-within .password-toggle {
            color: #3949ab;
        }
        
        .password-toggle:hover {
            color: #1a237e;
        }
        
        .btn-login {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(to right, #3949ab, #1a237e);
            color: white;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            margin-top: 1.75rem;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(57, 73, 171, 0.35);
            letter-spacing: 0.05em;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-login:hover {
            background: linear-gradient(to right, #303f9f, #1a237e);
            box-shadow: 0 6px 16px rgba(57, 73, 171, 0.45);
            transform: translateY(-2px);
        }
        
        .btn-login:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(57, 73, 171, 0.3);
        }
        
        .btn-login i {
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }
        
        .settings-icon {
            position: fixed;
            bottom: 2rem;
            left: 2rem;
            width: 3.5rem;
            height: 3.5rem;
            background: linear-gradient(135deg, #3949ab, #1a237e);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            z-index: 20;
        }
        
        .settings-icon:hover {
            transform: rotate(30deg) scale(1.1);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.4);
        }
        
        .version-info {
            position: fixed;
            bottom: 1rem;
            right: 1rem;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.75rem;
            z-index: 20;
            font-weight: 500;
        }
        
        .error-container {
            background-color: #fee2e2;
            border-left: 4px solid #ef4444;
            padding: 1rem;
            margin-bottom: 1.75rem;
            border-radius: 0.5rem;
            animation: shake 0.5s ease-in-out;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.2);
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        
        .error-text {
            color: #b91c1c;
            font-size: 0.875rem;
            padding-left: 0.5rem;
        }
    </style>
</head>
<body>
    <!-- Background shapes -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>
    
    <div class="login-container">
        <div class="form-container">
            <!-- Logo and Title -->
            <div class="logo-container">
                <div class="logo-circle">
                   <img src="{{ Storage::url('images/logo2.png') }}" class="object-contain w-4/5 h-4/5">
                </div>
                <div class="app-title">SISTEM INFORMASI MOLDING</div>
                <div class="company-name">PT VOLEX INDONESIA</div>
            </div>

            <!-- Error Alert -->
            @if ($errors->any())
                <div class="error-container">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-600"></i>
                        </div>
                        <div class="ml-3">
                            @foreach ($errors->all() as $error)
                                <p class="error-text">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <!-- Username Input -->
                <div class="input-container">
                    <div class="input-icon-wrapper">
                        <i class="fas fa-user"></i>
                    </div>
                    <input id="username" name="username" type="text" required
                        class="input-field" placeholder="Enter Username">
                </div>
                
                <!-- Password Input -->
                <div class="input-container">
                    <div class="input-icon-wrapper">
                        <i class="fas fa-lock"></i>
                    </div>
                    <input id="password" name="password" type="password" required
                        class="input-field" placeholder="Enter Password">
                    <i class="fas fa-eye password-toggle" id="togglePassword" onclick="togglePasswordVisibility()"></i>
                </div>
                
                <!-- Login Button -->
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> LOGIN
                </button>
            </form>
        </div>
        
        <!-- Settings Icon -->
        <div class="settings-icon">
            <i class="fas fa-cog"></i>
        </div>
        
        <!-- Version Info -->
        <div class="version-info">v1.0.0</div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePassword');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
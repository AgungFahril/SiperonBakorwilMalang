<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPERON - Login')</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        body {
            background: linear-gradient(135deg, rgba(5, 20, 40, 0.75), rgba(0, 8, 20, 0.88)), url("{{ asset('images/bg_bakorwil.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 2rem;
            font-family: 'Inter', sans-serif;
        }

        .auth-container {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
            width: 100%;
            max-width: 480px;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }
        
        /* decorative blob */
        .auth-container::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, #08a6d9, #0284c7);
            border-radius: 50%;
            opacity: 0.15;
            z-index: 0;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2.5rem;
            position: relative;
            z-index: 1;
        }

        .auth-brand {
            font-size: 2rem;
            font-weight: 800;
            color: #08a6d9;
            margin-bottom: 0.5rem;
            display: inline-block;
            letter-spacing: -0.5px;
        }

        .auth-brand span {
            color: #38bdf8;
        }

        .auth-subtitle {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.95rem;
        }

        .auth-form {
            position: relative;
            z-index: 1;
        }

        .auth-form .form-group {
            margin-bottom: 1.5rem;
        }

        .auth-form .form-label {
            margin-bottom: 0.5rem;
            display: block;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.9rem;
        }

        .auth-form .form-control {
            width: 100%;
            padding: 0.85rem 1.2rem;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .auth-form .form-control::placeholder {
            color: rgba(255, 255, 255, 0.35);
        }

        .auth-form .form-control:focus {
            background: rgba(255, 255, 255, 0.12);
            border-color: #08a6d9;
            box-shadow: 0 0 0 4px rgba(8, 166, 217, 0.15);
            outline: none;
            color: #ffffff;
        }

        .auth-form label[for="remember"],
        .auth-form label[for="terms"] {
            color: rgba(255, 255, 255, 0.6) !important;
        }

        .auth-button {
            width: 100%;
            padding: 1rem;
            border-radius: 10px;
            background: linear-gradient(135deg, #08a6d9, #0284c7);
            color: white;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(8, 166, 217, 0.3);
            margin-top: 1rem;
        }

        .auth-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(8, 166, 217, 0.45);
        }

        .auth-footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.5);
            position: relative;
            z-index: 1;
        }

        .auth-link {
            color: #38bdf8;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .auth-link:hover {
            color: #08a6d9;
        }
        
        .auth-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.85rem;
        }
        
        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }
        
        .auth-divider:not(:empty)::before {
            margin-right: .5em;
        }
        
        .auth-divider:not(:empty)::after {
            margin-left: .5em;
        }

        /* Error message styling for dark theme */
        .auth-form div[style*="background: #fee2e2"] {
            background: rgba(239, 68, 68, 0.15) !important;
            color: #fca5a5 !important;
            border: 1px solid rgba(239, 68, 68, 0.25);
        }

        /* Show password button */
        .auth-form button[onclick*="togglePassword"] {
            color: rgba(255, 255, 255, 0.4) !important;
        }
        .auth-form button[onclick*="togglePassword"]:hover {
            color: rgba(255, 255, 255, 0.7) !important;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <div class="auth-brand">SIPERON</div>
            <div class="auth-subtitle">@yield('subtitle')</div>
        </div>
        
        @yield('content')
    </div>
</body>
</html>

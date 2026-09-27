<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPERON - Login')</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        body {
            background: linear-gradient(135deg, var(--bakorwil-cyan-light) 0%, var(--bakorwil-blue-light) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 2rem;
            font-family: 'Inter', sans-serif;
        }

        .auth-container {
            background-color: var(--bg-surface);
            border-radius: 20px;
            box-shadow: var(--shadow-float-md);
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
            background: linear-gradient(135deg, var(--bakorwil-cyan), var(--bakorwil-blue));
            border-radius: 50%;
            opacity: 0.1;
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
            color: var(--bakorwil-blue);
            margin-bottom: 0.5rem;
            display: inline-block;
            letter-spacing: -0.5px;
        }

        .auth-brand span {
            color: var(--bakorwil-cyan);
        }

        .auth-subtitle {
            color: var(--text-muted);
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
            color: var(--text-heading);
            font-size: 0.9rem;
        }

        .auth-form .form-control {
            width: 100%;
            padding: 0.85rem 1.2rem;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background-color: #f8fafc;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .auth-form .form-control:focus {
            background-color: #fff;
            border-color: var(--bakorwil-cyan);
            box-shadow: 0 0 0 4px rgba(0, 188, 212, 0.1);
            outline: none;
        }

        .auth-button {
            width: 100%;
            padding: 1rem;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--bakorwil-cyan), var(--bakorwil-blue));
            color: white;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-float-cyan);
            margin-top: 1rem;
        }

        .auth-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -4px rgba(2, 132, 199, 0.4);
        }

        .auth-footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.9rem;
            color: var(--text-muted);
            position: relative;
            z-index: 1;
        }

        .auth-link {
            color: var(--bakorwil-blue);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .auth-link:hover {
            color: var(--bakorwil-cyan);
        }
        
        .auth-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
            color: var(--text-muted);
            font-size: 0.85rem;
        }
        
        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--border-color);
        }
        
        .auth-divider:not(:empty)::before {
            margin-right: .5em;
        }
        
        .auth-divider:not(:empty)::after {
            margin-left: .5em;
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

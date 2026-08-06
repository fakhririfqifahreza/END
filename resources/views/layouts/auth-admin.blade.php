<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Warung Sembako CPM')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 1200px;
        }

        .auth-card {
            background: #ffffff;
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            z-index: 10;
            font-size: 1.1rem;
        }

        .form-control {
            padding: 0.75rem 1rem 0.75rem 3rem;
            border: 2px solid #e5e7e9;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        .form-control:focus {
            border-color: #03AC0E;
            box-shadow: 0 0 0 4px rgba(3, 172, 14, 0.1);
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .btn-login, .btn-register {
            width: 100%;
            padding: 0.85rem;
            background: linear-gradient(135deg, #03AC0E 0%, #028A0F 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(3, 172, 14, 0.3);
            font-family: 'Poppins', sans-serif;
        }

        .btn-login:hover, .btn-register:hover {
            background: linear-gradient(135deg, #028A0F 0%, #026D0B 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(3, 172, 14, 0.4);
        }

        .link-register, .link-login {
            color: #03AC0E;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .link-register:hover, .link-login:hover {
            color: #028A0F;
            text-decoration: underline;
        }

        .form-check-input:checked {
            background-color: #03AC0E;
            border-color: #03AC0E;
        }

        .form-check-input:focus {
            border-color: #03AC0E;
            box-shadow: 0 0 0 0.25rem rgba(3, 172, 14, 0.25);
        }

        .alert {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            border: none;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .admin-badge {
            display: inline-block;
            background: linear-gradient(135deg, #03AC0E 0%, #028A0F 100%);
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 6px rgba(3, 172, 14, 0.3);
            margin-top: 0.5rem;
        }

        @media (max-width: 576px) {
            .auth-card {
                padding: 2rem 1.5rem;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    {{-- MAIN CONTENT --}}
    <div class="auth-wrapper">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto hide alerts after 3 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    // Add fade out animation
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    
                    // Remove from DOM after animation
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                }, 3000); // 3 seconds
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>

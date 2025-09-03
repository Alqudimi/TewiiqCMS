<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$this->e($title ?? 'Tewiiq - تويق')?></title>
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    
    <!-- Google Fonts - Arabic Font -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Light Mode Variables */
            --primary-light: #7c4dff;
            --secondary-light: #ff6e6c;
            --accent-light: #2ce0c8;
            --background-light: #f8f9fa;
            --text-light: #2d3748;
            --card-light: #ffffff;
            --input-light: #f1f3f4;
            --border-light: #e2e8f0;
            
            /* Dark Mode Variables */
            --primary-dark: #9370ff;
            --secondary-dark: #ff8c8a;
            --accent-dark: #3af0da;
            --background-dark: #1a202c;
            --text-dark: #e2e8f0;
            --card-dark: #2d3748;
            --input-dark: #4a5568;
            --border-dark: #4a5568;
            
            --border-radius: 16px;
            --transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            --box-shadow: 0 12px 36px rgba(0, 0, 0, 0.15);
            
            /* Initial values - light mode by default */
            --primary: var(--primary-light);
            --secondary: var(--secondary-light);
            --accent: var(--accent-light);
            --background: var(--background-light);
            --text: var(--text-light);
            --card: var(--card-light);
            --input: var(--input-light);
            --border: var(--border-light);
        }

        .dark-mode {
            --primary: var(--primary-dark);
            --secondary: var(--secondary-dark);
            --accent: var(--accent-dark);
            --background: var(--background-dark);
            --text: var(--text-dark);
            --card: var(--card-dark);
            --input: var(--input-dark);
            --border: var(--border-dark);
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background-color: var(--background);
            color: var(--text);
            transition: var(--transition);
            min-height: 100vh;
            line-height: 1.6;
            padding-top: 76px;
        }

        .navbar {
            background-color: var(--card);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 1rem;
            transition: var(--transition);
            border-bottom: 1px solid var(--border);
        }

        .navbar-brand {
            font-weight: 800;
            color: var(--primary);
            font-size: 1.75rem;
            display: flex;
            align-items: center;
        }

        .nav-link {
            color: var(--text);
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        .nav-link:hover, .nav-link.active {
            background-color: var(--input);
            color: var(--primary);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: var(--border-radius);
            padding: 0.6rem 1.5rem;
            font-weight: 700;
            transition: var(--transition);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(124, 77, 255, 0.4);
        }

        .form-control {
            background-color: var(--input);
            border: 2px solid var(--border);
            border-radius: var(--border-radius);
            color: var(--text);
            transition: var(--transition);
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(124, 77, 255, 0.2);
            border-color: var(--primary);
            background-color: var(--card);
        }

        .card {
            background-color: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--border-radius);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
        }

        .alert {
            border-radius: var(--border-radius);
            border: none;
        }

        .alert-success {
            background-color: rgba(44, 224, 200, 0.1);
            color: var(--accent);
        }

        .alert-danger {
            background-color: rgba(255, 110, 108, 0.1);
            color: var(--secondary);
        }
    </style>
    <?php if (isset($customCSS)): ?>
        <style><?=$customCSS?></style>
    <?php endif; ?>
</head>
<body>
    <?=$this->section('content')?>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <?php if (isset($customJS)): ?>
        <script><?=$customJS?></script>
    <?php endif; ?>
</body>
</html>
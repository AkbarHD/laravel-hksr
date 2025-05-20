<style>
    :root {
        --primary-color: #e63946;
        --secondary-color: #1d3557;
        --light-color: #f1faee;
        --medium-color: #a8dadc;
        --dark-color: #457b9d;
    }

    body {
        font-family: 'Poppins', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
    }

    .navbar {
        background-color: rgb(255, 255, 255) !important;
    }

    .navbar-brand {
        display: flex;
        align-items: center;
        font-weight: 700;
        color: black !important;
    }

    .navbar-brand img {
        margin-right: 10px;
    }

    .nav-link {
        color: black !important;
        font-weight: 500;
        margin: 0 10px;
        transition: all 0.3s;
    }

    .nav-link:hover {
        color: var(--medium-color) !important;
    }

    .btn-report {
        background-color: var(--primary-color);
        color: white;
        border: none;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-report:hover {
        background-color: #c1121f;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.8)),
        url('{{ asset('assets/images/frontend/bg-hero.jpg') }}') center/cover no-repeat;
        color: white;
        padding: 100px 0;
        position: relative;
    }

    .hero-text h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .hero-text p {
        font-size: 1.2rem;
        margin-bottom: 30px;
    }

    .info-card {
        background-color: white;
        border-radius: 10px;
        transition: all 0.3s;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        height: 100%;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .info-card .card-title {
        color: var(--secondary-color);
        font-weight: 600;
    }

    .info-card .card-icon {
        font-size: 2.5rem;
        color: var(--primary-color);
        margin-bottom: 20px;
    }

    .section-title {
        position: relative;
        display: inline-block;
        margin-bottom: 40px;
        color: var(--secondary-color);
        font-weight: 700;
    }

    .section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -10px;
        width: 50px;
        height: 3px;
        background-color: var(--primary-color);
    }

    .modul-card {
        border: none;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s;
    }

    .modul-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .modul-card .card-img-top {
        height: 180px;
        object-fit: cover;
    }

    .modul-card .card-body {
        padding: 20px;
    }

    .modul-card .card-title {
        font-weight: 600;
        color: var(--secondary-color);
    }

    .modul-card .card-text {
        color: #6c757d;
        margin-bottom: 20px;
    }

    .btn-primary {
        background-color: var(--dark-color);
        border: none;
        padding: 8px 16px;
        font-weight: 500;
    }

    .btn-primary:hover {
        background-color: var(--secondary-color);
    }

    .stat-card {
        background-color: var(--medium-color);
        border-radius: 10px;
        padding: 30px 20px;
        text-align: center;
        height: 100%;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--secondary-color);
        margin-bottom: 10px;
    }

    .stat-label {
        font-size: 1rem;
        color: var(--secondary-color);
        font-weight: 500;
    }

    .footer {
        background-color: var(--secondary-color);
        color: white;
        padding: 60px 0 30px;
    }

    .footer-title {
        font-weight: 600;
        margin-bottom: 20px;
        font-size: 1.2rem;
    }

    .footer-links {
        list-style: none;
        padding-left: 0;
    }

    .footer-links li {
        margin-bottom: 10px;
    }

    .footer-links a {
        color: var(--light-color);
        text-decoration: none;
        transition: all 0.3s;
    }

    .footer-links a:hover {
        color: var(--medium-color);
        text-decoration: underline;
    }

    .social-links a {
        display: inline-block;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.1);
        text-align: center;
        line-height: 36px;
        margin-right: 10px;
        color: white;
        transition: all 0.3s;
    }

    .social-links a:hover {
        background-color: var(--primary-color);
        transform: translateY(-3px);
    }

    .copyright {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        font-size: 0.9rem;
    }
</style>

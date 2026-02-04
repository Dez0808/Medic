<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
    <style>
        :root {
            --primary-color: green;
            --secondary-color: blue;
            --font-color: white;
            --gradient-color: linear-gradient(90deg, rgb(10, 89, 52) 50%, rgb(55, 123, 77) 100%);
            --input-color: #f1f1f1;
            --shadow: 0 2px 5px rgba(0, 0, 0, 0.2)
        }

        footer {
            background: var(--gradient-color);
            color: var(--font-color);
        }


        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: #0000001a;
            border: solid rgba(0, 0, 0, 0.15);
            border-width: 1px 0;
            box-shadow:
                inset 0 0.5em 1.5em #0000001a,
                inset 0 0.125em 0.5em #00000026;
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -0.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;
            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }

        .bd-mode-toggle .bi {
            width: 1em;
            height: 1em;
        }

        .bd-mode-toggle .dropdown-menu .active .bi {
            display: block !important;
        }
    </style>
</head>

<body>
    <footer class="row-cols-1 row-cols-sm-2 row-cols-md-4 py-5 px-4" style="display: flex;">
        <div class="col mb-3">
            <a href="/" class="d-flex align-items-center mb-3 link-body-emphasis text-decoration-none"
                aria-label="Bootstrap">
                <img src="../include/Lagro_High_School_logo.png" alt="" width="80" height="80" class="me-2">
                <div style="color: var(--font-color);">
                    <h2 style="font-size: 28px; margin-top: 12px;">Lagro Clinic</h2>
                    <p style="font-size: 15px; margin-top: -8px;">Sa lagro lalala ka!</p>
                </div>
            </a>
            <p class="">Misa De Gallo St., Brgy. Greater Lagro District V, Quezon City.</p>
        </div>
        <div class="col mb-3"></div>
        <div class="col mb-3">
            <!-- <h5>Contact Info</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="#" class="nav-link p-0 ">Home</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="#" class="nav-link p-0 ">Features</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="#" class="nav-link p-0 ">Pricing</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="#" class="nav-link p-0 ">FAQs</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="#" class="nav-link p-0 ">About</a>
                </li>
            </ul>
        </div>
        <div class="col mb-3">
            <h5>Social Media</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="#" class="nav-link p-0 ">Home</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="#" class="nav-link p-0 ">Features</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="#" class="nav-link p-0 ">Pricing</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="#" class="nav-link p-0 ">FAQs</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="#" class="nav-link p-0 ">About</a>
                </li>
            </ul>
        </div> -->

    </footer>
</body>

</html>
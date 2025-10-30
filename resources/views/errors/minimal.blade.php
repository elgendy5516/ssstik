<!doctype html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=yes, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title')</title>

    <!-- For Window Tab Color -->
    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#062446FF">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#062446FF">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#062446FF">

    <!-- Favicon -->
    <link rel="icon" href="{{asset('favicon.png')}}" type="image/png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            --font-family: 'Nunito', sans-serif;
            font-family: var(--font-family);

            --clr-primary: hsl(331, 93%, 48%);
            --clr-primary-dark--90: hsla(331, 93%, 40%, 0.9);
            --clr-primary--05: hsla(331, 93%, 48%, 0.05);
            --clr-primary--10: hsla(331, 93%, 48%, 0.1);
            --clr-primary--20: hsla(331, 93%, 48%, 0.2);
            --clr-primary--50: hsla(331, 93%, 48%, 0.5);
        }

        .error-page {
            background-color: #fff;
            min-width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center
        }

        @media screen and (max-width: 820px) {
            .error-page {
                padding: 1rem
            }
        }

        .error-page-body {
            display: flex;
            align-items: flex-start
        }

        @media screen and (max-width: 820px) {
            .error-page-body {
                flex-direction: column;
            }
        }

        .error-page h2 {
            font-size: 3.5rem;
            color: var(--clr-primary);
            font-weight: 700;
            line-height: 1;
        }

        @media screen and (max-width: 820px) {
            .error-page h2 {
                font-size: 3rem;
                margin-bottom: .625rem;
            }
        }

        .error-page-content {
            margin-left: 2rem;
        }

        @media screen and (max-width: 820px) {
            .error-page-content {
                margin-left: 0;
            }
        }

        .error-page-content-text {
            padding-left: 2rem;
            position: relative;
        }

        .error-page-content-text:before {
            content: " ";
            position: absolute;
            top: 0;
            left: 0;
            width: 2px;
            height: 100%;
            background-color: rgba(0, 0, 0, .1);
        }

        .error-page-content-text h3 {
            font-size: 3.25rem;
            color: rgba(0, 0, 0, .85);
            font-weight: 700;
            line-height: 1;
        }

        .error-page-content-text p {
            margin-top: 6px;
            font-size: 1.125rem;
            color: rgba(0, 0, 0, .55);
            font-weight: 400;
            line-height: 1.26
        }

        @media screen and (max-width: 820px) {
            .error-page-content-text {
                padding-left: 0
            }

            .error-page-content-text:before {
                content: none
            }

            .error-page-content-text h3 {
                font-size: 2.5rem
            }
        }

        .error-page-content-action {
            padding-left: 2rem;
            margin-top: 3rem;
            display: flex;
            justify-content: flex-start;
            align-items: center
        }

        @media screen and (max-width: 820px) {
            .error-page-content-action {
                padding-left: 0;
                margin-top: 2rem;
            }
        }

        .error-page-content-action a {
            height: 36px;
            border-radius: 6px;
            text-decoration: none;
            padding: 8px 19px;
            margin-right: 14px;
            font-weight: 500;
            line-height: 1;
            display: flex;
            align-items: center;
            font-size: 14px;
            --ep-btn-bg-color: var(--clr-primary--05);
            --ep-btn-color: var(--clr-primary);
            --ep-btn-hover-bg-color: var(--clr-primary--10);
            --ep-btn-hover-color: var(--clr-primary);
            background-color: var(--ep-btn-bg-color);
            color: var(--ep-btn-color);
            transition: color .2s, background-color .2s ease-in-out
        }

        .error-page-content-action a.is-action {
            --ep-btn-bg-color: var(--clr-primary);
            --ep-btn-color: white;
            --ep-btn-hover-color: var(--ep-btn-color);
            --ep-btn-hover-bg-color: var(--clr-primary-dark--90)
        }

        .error-page-content-action a:where(:hover,:focus-visible) {
            color: var(--ep-btn-hover-color);
            background-color: var(--ep-btn-hover-bg-color)
        }

        .error-page-content-action a:where(:focus-visible) {
            outline: 2px solid var(--clr-primary--50);
            outline-offset: 1px
        }
    </style>
</head>
<body>
<section class="error-page">
    <div class="error-page-body">
        <h2>@yield('code')</h2>
        <div class="error-page-content">
            <div class="error-page-content-text">
                <h3>@yield('title')</h3>
                <p>@yield('message')</p>
            </div>
            <div class="error-page-content-action">
                <a class="is-action" href="{{url('/')}}">Go back home</a>
                <a href="{{ "mailto:support@".request()->getHost() }}" class="is-default">Contact support</a>
            </div>
        </div>
    </div>
</section>
</body>
</html>

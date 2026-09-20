    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>@yield('title')</title>
        <link rel="icon" href="/favicon.ico">
    </head>
    <body>
        <header>
            <hr>
            <h1>Library System</h1>
    
            <nav>
            <a href="/dashboard">Dashboard</a> |
            <a href="/books">Books</a> |
            <a href="/categories">Categories</a> |
            <a href="/members">Members</a>
            </nav>
            
            <hr>
        </header>

        <main>
            @yield('content')
        </main>

        <footer>
            <hr>
            <p>Library System</p>
        </footer>
    </body>
    </html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
<div class="dash">
    <aside class="sidebar">
        <div class="brand">
            <div class="avatar">{{ strtoupper($user['nomUtilisateur'][0])}}</div>
            <div class="brand-text">
                <div class="brand-title">{{strtoupper($user['nomUtilisateur'])}}</div>
                <div class="brand-sub">UPVD</div>
            </div>
        </div>

        <nav class="menu">
            <a class="item active" href="#"><span>🏠</span> Tableau de bord</a>
            <a class="item" href="#"><span>👤</span> Utilisateurs</a>
            <a class="item" href="#"><span>🏫</span> Gestion des salles</a>
            <a class="item" href="#"><span>📅</span> Réservations</a>
            <a class="item" href="#"><span>📊</span> Rapports</a>
            <a class="item" href="#"><span>⚙️</span> Paramètres</a>
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="/logout">
                @csrf
                <button class="logout" type="submit">⎋ Déconnexion</button>
            </form>
        </div>
    </aside>

    <main class="content">
        @yield('content')
    </main>
</div>
</body>
</html>

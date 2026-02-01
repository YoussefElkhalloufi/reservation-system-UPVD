@extends('layouts.dashboard')
@section('title', 'Gestion Utilisateurs')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/utilisateurs.css') }}">
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const select = document.getElementById('roleFilter');
            const rows = document.querySelectorAll('.user-row');

            const searchInput = document.getElementById('searchInput');

            function applyRoleFilter() {
                const selectedRole = select.value; // "" / admin / etudiant / enseignant

                rows.forEach(row => {
                    const rowRole = row.dataset.role;

                    if (selectedRole === "" || rowRole === selectedRole) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            }

            // 1) Filtre rôle (inchangé, juste appelle la fonction)
            select.addEventListener('change', () => {
                applyRoleFilter();

                // si une recherche est en cours, on la ré-applique après le rôle
                const query = searchInput.value.toLowerCase().trim();
                if (query !== "") {
                    rows.forEach(row => {
                        if (row.style.display !== "none") { // ne toucher que les lignes visibles par rôle
                            const text = row.innerText.toLowerCase();
                            if (!text.includes(query)) row.style.display = "none";
                        }
                    });
                }
            });

            // 2) Recherche
            searchInput.addEventListener('input', () => {
                const query = searchInput.value.toLowerCase();
                // si vide => retour à l’état "filtre rôle"
                if (query === "") {
                    applyRoleFilter();
                    return;
                }
                // sinon : on repart de l’état rôle, puis on filtre par texte
                applyRoleFilter();
                rows.forEach(row => {
                    if (row.style.display !== "none") {
                        const text = (row.dataset.search || "");
                        if (!text.includes(query)) row.style.display = "none";
                    }
                });
            });

        });
    </script>
@endsection


@section('content')
    <div class="users-page">

        <div class="page-head">
            <h1 class="page-title">Gestion des utilisateurs</h1>

            <div class="toolbar">
                <button type="button" class="btn-primary">
                    <span class="icon">+</span>
                    Ajouter un utilisateur
                </button>

                <div class="filters">
                    <div class="input-search">
                        <span class="search-ico">🔍</span>
                        <input id="searchInput" type="text" placeholder="Recherche...">
                    </div>

                    <select id="roleFilter">
                        <option value="">Filtrer par rôle</option>
                        <option value="admin">Admin</option>
                        <option value="etudiant">Étudiant</option>
                        <option value="enseignant">Enseignant</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="table-wrap">
                <table class="users-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom Prénom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Téléphone</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($users as $u)
                        @php
                            $nomComplet = trim($u->nom.' '.$u->prenom);
                            $statutTxt = $u->actif ? 'actif' : 'inactif';

                            // Texte "indexé" pour la recherche (tout en minuscule)
                            $searchText = strtolower(
                                $u->idUtilisateur.' '.$nomComplet.' '.$u->adresseMail.' '.$u->role.' '.$u->telephone
                                .' '.$statutTxt
                            );
                        @endphp

                        <tr class="user-row" data-role="{{ $u->role }}" data-search="{{ $searchText }}">
                            <td class="muted">{{ $u->idUtilisateur }}</td>
                            <td class="name">{{strtoupper($u->nom) }} {{ $u->prenom }}</td>
                            <td class="muted">{{ $u->adresseMail }}</td>
                            <td>{{ ucfirst($u->role) }}</td>
                            <td class="muted">{{$u->telephone}}</td>
                            <td>
                                @if($u->actif)
                                    <span class="badge badge-green">Actif</span>
                                @else
                                    <span class="badge badge-gray">Inactif</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn-edit">Éditer</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty">Aucun utilisateur trouvé</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

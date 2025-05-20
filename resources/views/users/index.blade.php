@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('users.index') }}" class="text-decoration-none text-dark">
            <h1 class="mb-0">Usuarios</h1>
        </a>
        <div class="d-flex gap-2">
            <a class="btn btn-success btn-lg" href="{{ route('users.create') }}">
                <i class="bi bi-plus-circle me-1"></i> Crear usuario
            </a>
            <a class="btn btn-warning btn-lg" href="{{ route('users.stats') }}">
                <i class="bi bi-bar-chart-fill me-1"></i> Estadísticas
            </a>
        </div>
    </div>

    <form method="GET" action="{{ route('users.index') }}" class="mb-4 d-flex justify-content-between align-items-center">
        <div class="input-group me-2" style="max-width: 400px;">
            <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o email" value="{{ request('search') }}">
            <button class="btn btn-outline-primary" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>


    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Email</th>
                            <th scope="col">Género</th>
                            <th scope="col">Edad</th>
                            <th scope="col" class="text-center">Ver más</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-light text-secondary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>{{ $user->name }}</div>
                                    </div>
                                </td>  
                                <td class="align-middle">{{ $user->email }}</td>
                                <td class="align-middle">
                                    @if($user->gender == 'male')
                                        <span class="badge bg-primary">{{ $user->gender }}</span>
                                    @elseif($user->gender == 'female')
                                        <span class="badge bg-success">{{ $user->gender }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $user->gender }}</span>
                                    @endif
                                </td>
                                <td class="align-middle">{{ $user->age }}</td>
                                <td class="text-center align-middle">
                                    <div class="btn-group" role="group">
                                        <a type="button" class="btn btn-outline-primary" href="{{ route('users.show', $user) }}" data-bs-toggle="tooltip" title="Ver detalles">
                                            <i class="fa-regular fa-user"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

                <div class="d-flex justify-content-center mt-4">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            {{-- Botón Anterior --}}
                            <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $users->previousPageUrl() }}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            
                            {{-- Números de página --}}
                            @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                <li class="page-item {{ $users->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                            
                            {{-- Botón Siguiente --}}
                            <li class="page-item {{ !$users->hasMorePages() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $users->nextPageUrl() }}" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<style>
    .avatar {
        font-weight: 500;
        font-size: 1rem;
    }
    .table th {
        font-weight: 600;
    }
    .pagination {
        justify-content: center;
        gap: 0.5rem;
    }
    .pagination .page-link {
        font-size: 0.9rem;
        padding: 0.375rem 0.75rem;
    }
    .bi {
        font-size: 1rem;
        vertical-align: middle;
    }
</style>
@endpush


@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        const searchInput = document.getElementById('search');
        const genderFilter = document.getElementById('genderFilter');
        const sortBy = document.getElementById('sortBy');
        const tableRows = document.querySelectorAll('tbody tr');

        function filterTable() {
            const searchValue = searchInput.value.toLowerCase();
            const genderValue = genderFilter.value.toLowerCase();
            
            tableRows.forEach(row => {
                const name = row.cells[0].textContent.toLowerCase();
                const email = row.cells[1].textContent.toLowerCase();
                const gender = row.cells[2].textContent.toLowerCase();
                
                const matchesSearch = name.includes(searchValue) || email.includes(searchValue);
                const matchesGender = !genderValue || gender.includes(genderValue);
                
                row.style.display = (matchesSearch && matchesGender) ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        genderFilter.addEventListener('change', filterTable);

        sortBy.addEventListener('change', function() {
            const tbody = document.querySelector('tbody');
            const rowsArray = Array.from(tableRows);
            const column = this.value;
            
            let index;
            switch(column) {
                case 'name': index = 0; break;
                case 'email': index = 1; break;
                case 'age': index = 3; break;
                default: index = 0;
            }
            
            rowsArray.sort((a, b) => {
                let aValue = a.cells[index].textContent.trim();
                let bValue = b.cells[index].textContent.trim();
                
                if (column === 'age') {
                    return parseInt(aValue) - parseInt(bValue);
                } else {
                    return aValue.localeCompare(bValue);
                }
            });
            
            rowsArray.forEach(row => tbody.appendChild(row));
        });
    });
</script>
@endpush
@endsection
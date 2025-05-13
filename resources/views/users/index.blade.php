@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header with Title and Buttons -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Usuarios</h1>
        <div class="d-flex gap-2">
            <a class="btn btn-success" href="{{ route('users.create') }}">
                <i class="bi bi-plus-circle me-1"></i> Crear usuario
            </a>
            <a class="btn btn-warning" href="{{ route('users.stats') }}">
                <i class="bi bi-bar-chart-fill me-1"></i> Estadísticas
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <!-- Users Table -->
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
                                    @if($user->gender == 'Masculino')
                                        <span class="badge bg-primary">{{ $user->gender }}</span>
                                    @elseif($user->gender == 'Femenino')
                                        <span class="badge bg-info">{{ $user->gender }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $user->gender }}</span>
                                    @endif
                                </td>
                                <td class="align-middle">{{ $user->age }}</td>
                                <td class="text-center align-middle">
                                    <div class="btn-group" role="group">
                                        <a class="btn btn-sm btn-primary" href="{{ route('users.show', $user) }}" data-bs-toggle="tooltip" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">Confirmar eliminación</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro que deseas eliminar al usuario <strong>{{ $user->name }}</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(isset($users) && method_exists($users, 'links'))
                <div class="d-flex justify-content-center mt-4">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<!-- Add Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<style>
    .avatar {
        font-weight: 500;
    }
    .table th {
        font-weight: 600;
    }
    .pagination {
        --bs-pagination-active-bg: #0d6efd;
        --bs-pagination-active-border-color: #0d6efd;
    }
</style>
@endpush

@push('scripts')
<script>
    // Enable tooltips
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Basic search functionality
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

        // Basic sorting functionality
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
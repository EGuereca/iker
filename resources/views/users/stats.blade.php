@extends('layouts.app')

@section('content')
    <h1>Estadísticas de Usuarios</h1>

    <canvas id="generoChart" width="400" height="200"></canvas>
    <canvas id="edadChart" width="400" height="200"></canvas>
    <canvas id="detalleChart" width="400" height="200"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        fetch('{{ route('users.stats') }}')
            .then(response => response.json())
            .then(data => {
                const generoChart = new Chart(document.getElementById('generoChart'), {
                    type: 'pie',
                    data: {
                        labels: ['Hombres', 'Mujeres'],
                        datasets: [{
                            data: [data.genero.hombres, data.genero.mujeres],
                            backgroundColor: ['#36A2EB', '#FF6384']
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Distribución por Género'
                            }
                        }
                    }
                });

                const edadChart = new Chart(document.getElementById('edadChart'), {
                    type: 'bar',
                    data: {
                        labels: ['Menores de edad', 'Mayores de edad'],
                        datasets: [{
                            label: 'Cantidad',
                            data: [data.edad.menores, data.edad.mayores],
                            backgroundColor: ['#FFCE56', '#4BC0C0']
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Distribución por Edad'
                            }
                        }
                    }
                });

                const detalleChart = new Chart(document.getElementById('detalleChart'), {
                    type: 'bar',
                    data: {
                        labels: [
                            'Hombres Menores',
                            'Hombres Mayores',
                            'Mujeres Menores',
                            'Mujeres Mayores'
                        ],
                        datasets: [{
                            label: 'Cantidad',
                            data: [
                                data.detalle.hombres_menores,
                                data.detalle.hombres_mayores,
                                data.detalle.mujeres_menores,
                                data.detalle.mujeres_mayores
                            ],
                            backgroundColor: ['#8e44ad', '#3498db', '#e67e22', '#e74c3c']
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Cruce Edad-Género'
                            }
                        }
                    }
                });
            });
    </script>
@endsection

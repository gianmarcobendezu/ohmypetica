<!-- resources/views/clinical-history.blade.php -->
@extends('layouts.app')  <!-- O el nombre de tu layout -->

@section('content')
    <div class="container">
        <h1>Administrar Historia Clínica</h1>
        @livewire('clinical-history-component')  <!-- Aquí está el componente de Livewire -->
    </div>
@endsection
<script>
    // Asegúrate de que Livewire esté cargado antes de intentar escuchar eventos
    Livewire.on('closeModal', () => {
        // Lógica para cerrar el modal usando jQuery o el método que prefieras
        $('#modal').modal('hide'); // Si estás usando jQuery para controlar el modal
    });

    Livewire.on('refreshList', () => {
        // Lógica para refrescar la lista, como recargar la página o actualizar datos
        window.location.reload(); // O usa otro método para actualizar la lista
    });
</script>
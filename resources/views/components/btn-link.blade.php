<div>
    <button class="btn-project" type="submit" onclick="window.location.href='{{ $url }}'">
        {{ $text }}
    </button>
</div>
<style>
    .btn-project {
        color: black; /* Texto negro */
        background-color: transparent; /* Sin fondo */
        border: none; /* Sin contorno */
        padding: 10px 20px; /* Aumenta el padding según sea necesario */
        transition: background-color 0.3s, color 0.3s, transform 0.3s; /* Transición suave */
        cursor: pointer; /* Cambia el cursor a puntero */
        border-radius: 5px; /* Radio de bordes */ 
    }

    .btn-project:hover {
        background-color: #1a5eb3; /* Fondo azul al pasar el mouse */
        color: white; /* Texto blanco al pasar el mouse */
        transform: scale(1.1); /* Aumenta el tamaño del botón un 10% */
    }
</style>

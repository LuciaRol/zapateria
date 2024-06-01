function editarProducto(id) {
    var fila = document.getElementById('producto-' + id);
    var campos = fila.getElementsByClassName('editable');
    var textos = fila.getElementsByClassName('texto');

    for (var i = 0; i < campos.length; i++) {
        campos[i].style.display = 'inline';
    }

    for (var i = 0; i < textos.length; i++) {
        textos[i].style.display = 'none';
    }

    fila.getElementsByClassName('editar-btn')[0].style.display = 'none';
    fila.getElementsByClassName('guardar-btn')[0].style.display = 'inline';
    fila.getElementsByClassName('cancelar-btn')[0].style.display = 'inline';
}

function cancelarEdicion(id) {
    var fila = document.getElementById('producto-' + id);
    var campos = fila.getElementsByClassName('editable');
    var textos = fila.getElementsByClassName('texto');

    for (var i = 0; i < campos.length; i++) {
        campos[i].style.display = 'none';
    }

    for (var i = 0; i < textos.length; i++) {
        textos[i].style.display = 'inline';
    }

    fila.getElementsByClassName('editar-btn')[0].style.display = 'inline';
    fila.getElementsByClassName('guardar-btn')[0].style.display = 'none';
    fila.getElementsByClassName('cancelar-btn')[0].style.display = 'none';
}
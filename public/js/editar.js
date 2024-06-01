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

    // Mostrar botones relevantes
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

    // Ocultar botones relevantes
    fila.getElementsByClassName('editar-btn')[0].style.display = 'inline';
    fila.getElementsByClassName('guardar-btn')[0].style.display = 'none';
    fila.getElementsByClassName('cancelar-btn')[0].style.display = 'none';
}

function guardarProducto(id) {
    var fila = document.getElementById('producto-' + id);
    var campos = fila.getElementsByClassName('editable');
    
    for (var i = 0; i < campos.length; i++) {
        var nombreCampo = campos[i].getAttribute('name');
        var valorCampo = campos[i].value;
        
        // Actualizar el valor del campo oculto correspondiente
        var campoOculto = fila.querySelector('input[name="' + nombreCampo + '"]');
        if (campoOculto) {
            campoOculto.value = valorCampo;
        }
    }

    // Submit the form after updating hidden fields
    fila.querySelector('.guardar-btn').click();
}

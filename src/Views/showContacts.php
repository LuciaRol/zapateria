<?php

$numero_elementos_pagina = 2;
$pagination = new Zebra_Pagination();

$pagination->records(count ($contactos));

$pagination->records_per_page(($numero_elementos_pagina));
$contactos = array_slice(
    $contactos,
    (($pagination->get_page()-1) * $numeros_elementos_pagina),
    $numero_elementos_pagina
);

?>
    <h2>contactos</h2>

    <a href="<?BASE_URL?>Contacto/nuevoContacto">Nuevo contacto</a>

    <table>

        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Correos</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($contactos as $contacto):?>
            <tr>
                <th scope="col"><?= $contacto->getId()?></th>
                <td><?= $contacto->getnombre()?></td>
                <td><?= $contacto->getApellido()?></td>
                <td><?= $contacto->getTelefono()?></td>
                <td><?= $contacto->getCorreo()?></td>
                <td>
                    <a href="<?BASE_URL?>Contacto/editarContacto/?id=<?=$contacto->getId()?>">Editar contacto</a>
                    <a href="<?BASE_URL?>Contacto/borrarContacto/?id=<?=$contacto->getId()?>">Borrar contacto</a>
                </td>
            </tr>

            <?php endforeach; ?>
        </tbody>
    </table>

    <?php

    $paginaton->render();
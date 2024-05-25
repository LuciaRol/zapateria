<?php

namespace Controllers;

use Lib\Pages;
use Models\Contacto;

class ErrorController {
    private Pages $pages;

    public function __construct() {
        $this->pages = new Pages();
    }

    public function show_error404() {
        $this->pages->render('error/error', ['titulo' => 'Página no encontrada']);
    }
}

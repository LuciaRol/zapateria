<?php

namespace Lib;

class Pages {
    public function render(string $pageName, array $params = null): void {
        if($params !=null) {
            foreach($params as $name => $value) {
                $$name = $value;
            }
        }

        /*require_once 'Views/layout/header.php';*/
        require_once __DIR__ . "/../Views/layout/header.php";
        require_once __DIR__ . "/../Views/$pageName.php";
        require_once __DIR__ . "/../Views/layout/footer.php";

    }
}
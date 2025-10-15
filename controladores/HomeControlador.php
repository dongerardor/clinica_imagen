<?php

require_once __DIR__ . '/../core/helpers.php';

class HomeControlador
{
    public function inicio(): void
    {
        require view_path('home.php');
    }
}

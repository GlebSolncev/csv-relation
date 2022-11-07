<?php

namespace App\Controllers;

use App\Services\RelationService;

/**
 *
 */
class RelationController
{

    /**
     * @return void
     */
    public static function play()
    {
        $service = new RelationService();
        $service->withWithCSV();
    }
}
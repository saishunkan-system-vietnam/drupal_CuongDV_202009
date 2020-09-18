<?php 

namespace Drupal\mymodule\Controller;

use Drupal\Core\Controller\ControllerBase;

class MyModuleController extends ControllerBase {
    public function content() {
        return [
            '#type' => 'markup',
            '#markup' => t("This my custom page"),
        ];
    }
}
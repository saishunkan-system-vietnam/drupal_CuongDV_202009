<?php 

namespace Drupal\seminar\Controller;

use Drupal\Core\Controller\ControllerBase;

class SeminarController extends ControllerBase {

    /**
     * Get details Seminar
     */
    public function getDetail(){
        return [
            '#type' => 'markup',
            "#markup" => t("This Seminar Detail"),
        ];
    }
}
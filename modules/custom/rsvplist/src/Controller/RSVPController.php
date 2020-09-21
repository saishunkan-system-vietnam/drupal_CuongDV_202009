<?php 

namespace Drupal\rsvplist\Controller;

use Drupal\Core\Controller\ControllerBase;

class RSVPController extends ControllerBase {
    public function content() {
        return [
            '#type' => 'markup',
            '#markup' => t("This my custom page"),
        ];
    }
}
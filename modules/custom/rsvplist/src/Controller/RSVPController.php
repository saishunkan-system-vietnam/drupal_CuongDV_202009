<?php

namespace Drupal\rsvplist\Controller;

use Drupal\Core\Controller\ControllerBase;

class RSVPController extends ControllerBase
{
    public function content()
    {
        // Lấy tên  view page hiện tại
        $current_view = \Drupal\views\Plugin\views\display\Page::getPageRenderArray();
        $machinename_page = $current_view['#name'];
        return [
            '#markup' => $machinename_page,
        ];
    }
}

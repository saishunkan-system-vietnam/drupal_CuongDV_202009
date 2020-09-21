<?php

namespace Drupal\mymodule\Controller;

use Drupal\Core\Controller\ControllerBase;

class MyModuleController extends ControllerBase
{
    public function content()
    {
        return [
            '#type' => 'markup',
            '#markup' => t("This my custom page"),
        ];
    }

    public function callBlock()
    {
        $block = \Drupal\block\Entity\Block::load('welcometodk');
        $block_content = \Drupal::entityManager()
            ->getViewBuilder('block')
            ->view($block);
        return array('#markup' => \Drupal::service('renderer')->renderRoot($block_content));
    }
}

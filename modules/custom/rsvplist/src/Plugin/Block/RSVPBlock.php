<?php

/**
 * @file
 * contains  \Drupal\rsvplist\Plugin\Block\RSVPBlock
 */

namespace Drupal\rsvplist\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Provides a 'RSVP' ListBlock
 * @Block(
 * id = "rsvp_block",
 * admin_label = @Translation("RSVP Block"),
 * category = @Translation("RSVP List Block"),
 * )
 */
class RSVPBlock extends BlockBase
{
    /**
     * {@inheritdoc}
     */
    public function build()
    {
        return \Drupal::formBuilder()->getForm('Drupal\rsvplist\Form\RSVPForm');
    }
    public function blockAccess(AccountInterface $account)
    {
        /**@var \Drupal\node\Entity\Node $node */
        $node = \Drupal::routeMatch()->getParameter('node');
        $nid = $node->nid->value;
        if (is_numeric($nid)) {
            return AccessResult::allowedIfHasPermission($account, 'view rsvplist');
        }
        return AccessResult::forbidden();
    }
}

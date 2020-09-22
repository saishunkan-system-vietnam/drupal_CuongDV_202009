<?php

/**
 * @file
 * Contains \Drupal\rsvplist\Controller\ReportController
 */

namespace Drupal\rsvplist\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;

class ReportController extends ControllerBase
{
    /**
     * Get all RSVPs for all nodes.
     */
    protected function load()
    {
        $select  = Database::getConnection()->select('rsvplist', 'r');
        //Join the users table, so we can get the entry creator's username.
        $select->join('users_field_data', 'u', 'r.uid = u.uid');
        //Join the node table, so we can get the event's name.
        $select->join('node_field_data', 'n', 'r.uid = u.uid');
        //Select these specific fields for the output
        $select->addField('u', 'name', 'username');
        $select->addField('n', 'title');
        $select->addField('r', 'email');
        $entries = $select->execute()->fetchAll(\PDO::FETCH_ASSOC);
        return $entries;
    }
    /**
     * Creates the report page
     * @return array
     * Render array for report output
     */
    public function report()
    {
        $content = array();
        $content['message'] = array(
            '#markup' => $this->t('Bellow is a list of all Event RSVPs including username, email address and the name of event they will be atending.'),
        );
        $headers = array(
            t('name'),
            t('Event'),
            t('Email'),
        );
        $row = array();
        foreach ($entries = $this->load() as $entry) {
            //Sanitize each entry
            $row[] = array_map('Drupal\Component\Utility\Safemarkup::checkPlain', $entry);
        }
        $content['table'] = array(
            '#type' => 'table',
            '#header' => $headers,
            '#rows' => $row,
            '#empty' =>t('No entries avaible.'),
        );
        //Don't cache this page
        $content['#cache']['max-age'] = 0;
        return $content;
    }
}

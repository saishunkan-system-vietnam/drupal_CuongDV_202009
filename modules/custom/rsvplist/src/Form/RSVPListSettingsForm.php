<?php

/** 
 * @file
 * Contains\Drupal\rsvplist\Form\RSVPForm
 */

namespace Drupal\rsvplist\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\Request;


/**
 * Defines a form to configure RSVP List module settings
 * Tạo form config block
 */

class RSVPListSettingsForm extends ConfigFormBase
{
    /**
     * (@inheritdoc)
     */
    public function getFormId()
    {
        return "rsvplist_admin_settings";
    }

    /**
     * (@inheritdoc)
     */
    protected function getEditableConfigNames()
    {
        return [
            'rsvplist.settings'
        ];
    }
    public function buildForm(array $form, \Drupal\Core\Form\FormStateInterface $form_state, Request $request = NULL)
    {
        $types = node_type_get_names();
        $config = \Drupal::service('config.factory')->getEditable('rsvplist.settings');
        $form['rsvplist_types'] = array(
            '#type' => 'checkboxes',
            '#title' => $this->t('The content types to enable RSVP collection for'),
            '#default_value' => $config->get('allowed_types'),
            '#options' => $types,
            '#description' => t('On the specified node types, an RSVP option will be available and can be enable while that node is being edited.'),
        );
        $form['array_filter'] = array('#type' => 'value', '#value' => TRUE);
        return parent::buildForm($form, $form_state);
    }

    /**
     * (@inheritdoc)
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $allowed_types = array_filter($form_state->getValue('rsvplist_types'));
        sort($allowed_types);
        $config = \Drupal::service('config.factory')->getEditable('rsvplist.settings');
        $config->set('allowed_types', $allowed_types)->save();
        parent::submitForm($form, $form_state);
    }
}

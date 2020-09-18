<?php 
/** 
 * @file
 * Contains\Drupal\rsvplist\Form\RSVPForm
*/
namespace Drupal\rsvplist\Form;

use Drupal\Core\Database\Database;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class RSVPForm extends FormBase {
    /**
     * (@inheritdoc)
     */
    public function getFormId()
    {
        return "rsvplist_email_form";
    }

    /**
     * (@inheritdoc)
     */
    public function buildForm(array $form, \Drupal\Core\Form\FormStateInterface $form_state)
    {
        $node = \Drupal::routeMatch()->getParameter('node');
        $nid = $node->nid->value;
        $form['value'] = [
            '#title' => t("Email Address"),
            '#type' => "textfield",
            '#size' => 25,
            '#description' => t("We'll send updates to your email"),
            '#required' => TRUE
        ];
        $form['submit'] = [
            '#type' => "submit",
            '#value' => t("RSVP"),
        ];
        $form['nid'] = [
            '#type' => "hidder",
            '#value' => $nid,
        ];
        return $form;
    }
}
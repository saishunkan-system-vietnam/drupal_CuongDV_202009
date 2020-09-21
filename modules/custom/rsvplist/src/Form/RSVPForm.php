<?php 
/** 
 * @file
 * Contains\Drupal\rsvplist\Form\RSVPForm
*/
namespace Drupal\rsvplist\Form;

use Drupal\Core\Database\Database;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

use function Drupal\Component\Datetime\time;

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
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $node = \Drupal::routeMatch()->getParameter('node');
        $nid = $node->nid->value;
        $form['email'] = [
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
            '#type' => "hidden",
            '#value' => $nid,
        ];
        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
      $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id);
      db_insert('rsvplist')->fields(array(
        'email' => $form_state->getValue('email'),
        'nid' => $form_state->getValue('nid'),
        'uid' => $user->id,
        'created' => time(),
      ))->execute();
        drupal_set_message(t('Thanks you for your RSVP, you are on the list for the event.'));
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
      $email = $form_state->getValue('email');
      if( $email == !\Drupal::service('email.validator')->isValid($email)) {
        $form_state->setErrorByName('email', t("The email address %mail is not valid,", array('%mail'=>$email)));
      }
    }
}
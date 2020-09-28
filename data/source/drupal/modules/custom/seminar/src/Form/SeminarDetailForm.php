<?php

use Drupal\Core\Form\FormBase;

class SeminarDetailForm extends FormBase {

      /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'seminar_detail';
    }

    public function buildForm(array $form, \Drupal\Core\Form\FormStateInterface $form_state)
    {
        $node = \Drupal::routeMatch()->getParameter('node');
        $nid = $node->nid->value;
        $form['seminar_name'] = [
            '#title' => t('Seminar name'),
            '#type' => 'textfield',
            '#size' => 10,
            '#description' => t('Input name of Seminar'),
            '#require' => TRUE,
        ];
        $form['seminar_content'] = [
            '#title' => t('Seminar content'),
            '#type' => 'textfield',
            '#description' => t('Input name of Seminar'),
            '#require' => TRUE,
        ];
        $form['speaker_name[]'] = [
            '#title' => t('Speaker name'),
            '#type' => 'textfield',
            '#description' => t('Name of Speaker'),
            '#require' => TRUE,
        ];
        $form['img[]'] = [
            '#title' => t('Images of Speaker'),
            '#type' => 'textfield',
            '#description' => t('Input name of Seminar'),
            '#require' => TRUE,
        ];
        $form['place_date'] = [
            '#title' => t('Images of Speaker'),
            '#type' => 'date',
            '#description' => t('Input name of Seminar'),
            '#require' => TRUE,
        ];
        $form['regis_start_date'] = [
            '#title' => t('Images of Speaker'),
            '#type' => 'date',
            '#description' => t('Input name of Seminar'),
            '#require' => TRUE,
        ];
        $form['regis_end_date'] = [
            '#title' => t('Images of Speaker'),
            '#type' => 'date',
            '#description' => t('Input name of Seminar'),
            '#require' => TRUE,
        ];
        $form['submit'] = [
            '#type' => "submit",
            '#value' => t("Apply"),
        ];
          $form['nid'] = [
            '#type' => "hidden",
            '#value' => $nid,
        ];
        return $form;
    }
}
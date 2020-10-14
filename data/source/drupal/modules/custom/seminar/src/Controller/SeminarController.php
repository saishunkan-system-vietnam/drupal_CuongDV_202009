<?php

namespace Drupal\seminar\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Connection\Database\Connection;

/**
 * Provides route responses for the Example module.
 */
class SeminarController extends ControllerBase
{
    protected $request;
    protected $formBuilder;
    protected $session;
    protected $user;
    protected $conn;

    public function __construct()
    {
        $this->request = \Drupal::request();
        $this->formBuilder = \Drupal::formBuilder();
        $this->session = \Drupal::request()->getSession();
        $this->user = \Drupal::currentUser();
        $this->conn = Database::getConnection();
    }

    public function getForm($node)
    {
        $registrationForm = $this->formBuilder->getForm('Drupal\seminar\Form\RegisterSeminarForm');
        $this->session->set('NODE_ID', $node);
        return [
            '#theme' => 'formregistration',
            '#form' => $registrationForm,
        ];
    }

    public function confirm()
    {
        $status = $this->request->request->all();
        if($status == 1){
            return [
                '#type' => 'markup',
                '#markup' => t('Confirm Successfully'),
            ]; 
        } else {
            return [
                '#type' => 'markup',
                '#markup' => t('Confirm Fail'),
            ];
        }
    }

    public function test()
    {
        $taxonomyGender = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree('t_gender');
        print_r($taxonomyGender);
        return [
            '#type' => 'markup',
            '#markup' => t('This aaa'),
        ];
    }

    public function saveData(array $args, $table)
    {
      return $this->conn->insert($table)->fields($args)->execute(); 
    }

    public function listRegister($node) {
        $query = $this->conn->select('seminar_registration_details', 'srd');
        $query->join('seminar_registration','sr','srd.srid = sr.srid');
        $query->fields('sr');
        $query->condition('srd.nid', $node);
        $list_regis = $query->execute();
        $data = $list_regis->fetchAll();
        return [  
            '#theme' => 'list-register',
            '#items' => $data
        ];
    }
}

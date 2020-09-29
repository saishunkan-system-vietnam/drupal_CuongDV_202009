<?php

namespace Drupal\seminar\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;

class SeminarController extends ControllerBase
{

    protected $request;
    protected $formBuilder;
    protected $session;
    protected $conn;

    public function __construct()
    {
        $this->request = \Drupal::request();
        $this->formBuilder = \Drupal::formBuilder();
        $this->session = \Drupal::request()->getSession();
        $this->user = \Drupal::currentUser();
        $this->conn = Database::getConnection();
    }
    /**
     * Get details Seminar
     */
    public function getDetail()
    {
        return [
            '#theme' => 'my_template',
            '#test_var' => $this->t('Test Value'),
        ];
    }

    public function getFormDetail()
    {

        $form = $this->formBuilder->getForm('\Drupal\seminar\Form\SeminarDetailForm');
        return [
            '#theme' => 'seminar_registration_form',
            '#form' => $form,
        ];
    }

    public function confirm()
    {
        $data = $this->request->request->all();
        $seminar = [
            'description' => $data['description'],
            'name' => $data['name'],
            'place_date' => $data['place_date'],
            'regis_start_date' => $data['regis_start_date'],
            'regis_end_date' => $data['regis_end_date'],
            'created_at' => $data['created_at']
        ];
        $id_seminar = $this->saveData($seminar, 'seminar');
        foreach ($data['name'] as $key => $value) {
            $speaker = [
                'name' => $value,
                'img' => $data['img'][$key],
            ];
        }
        $seminar_detail = [
            'sid' => $id_seminar,
            ''
        ];
        return $data;
    }

    public function saveData(array $argc, string $table)
    {
        return db_insert($table)->fields($argc[])->excute();
    }
}

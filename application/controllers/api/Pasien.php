<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class Pasien extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pasien_model', 'pasien');

        $this->methods['index_get']['limit'] = 5;
    }
    public function index_get()
    {
        $id = $this->get('id');
        if ($id === null) {
            $pasien = $this->pasien->getPasien();
        } else {
            $pasien = $this->pasien->getPasien($id);
        }
        if ($pasien) {
            $this->response([
                'status' => true,
                'data' => $pasien
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'data' => 'id not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    public function index_delete()
    {
        $id = $this->delete('id');
        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->pasien->deletePasien($id) > 0) {
                //ok
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'data pasien has been deleted!'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                //id not found
                $this->response([
                    'status' => false,
                    'message' => 'id not found!'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
    public function index_post()
    {
        $data = [
            'id' => $this->post('id'),
            'no_pasien' => $this->post('no_pasien'),
            'nama' => $this->post('nama'),
            'email' => $this->post('email')
        ];
        if ($this->pasien->createPasien($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pasien has been created.'
            ], REST_Controller::HTTP_CREATED);
        } else {
            //id not found
            $this->response([
                'status' => false,
                'message' => 'failed to create new data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    public function index_put()
    {
        // kenapa dibedakan agar id masuk ke where
        $id = $this->put('id');
        $data = [
            'id' => $this->put('id'),
            'no_pasien' => $this->put('no_pasien'),
            'nama' => $this->put('nama'),
            'email' => $this->put('email')
        ];
        if ($this->pasien->updatePasien($data, $id) > 0) {
            $this->response([
                'status' => true,
                'message' => 'data pasien has been updated.'
            ], REST_Controller::HTTP_NO_CONTENT);
        } else {
            //id not found
            $this->response([
                'status' => false,
                'message' => 'failed to update data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}

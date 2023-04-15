<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use CodeIgniter\API\ResponseTrait;

class Mahasiswa extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->model = new MahasiswaModel;
    }

    public function index()
    {
       $data = $this->model->findAll();
       return $this->respond($data,200);
    }


    public function show($id = null)
    {
       $data = $this->model->where('id',$id)->findAll();
       if($data){
            return $this->respond($data,200);
       }else{
            return $this->failNotFound("Data tidak ditemukan");
       }
    
    }

    public function create()
    {
        $data = $this->request->getPost();

        if(!$this->model->save($data)){
            return $this->fail($this->model->errors());
        }
        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Berhasil Menambah Data'
            ]
            ];

        return $this->respond($response);
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        $data['id'] = $id;

        $ifExist = $this->model->where('id',$id)->findAll();
        if(!$ifExist){
            return $this->failNotFound("Data tidak ditemukan");
        }

        if(!$this->model->save($data)){
            return $this->fail($this->model->errors());
        }

        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Berhasil Mengubah Data'
            ]
        ];

        return $this->respond($response);
    }

    public function delete($id = null)
    {
        $data = $this->model->where('id',$id)->findAll();

        if($data){
            $this->model->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => [
                    'success' => 'Berhasil Menghapus Data'
                ]
            ];

            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound("Data Tidak Ditemukan");
        }
    }

}

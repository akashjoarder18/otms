<?php

namespace App\Repositories\Interfaces;

interface ProviderRepositoryInterface  
{
    public function all();

    public function details($id);

    public function store($data);

    public function find($id);

    public function update($data, $id);

    public function delete($id);
   
}

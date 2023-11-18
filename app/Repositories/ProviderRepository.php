<?php

namespace App\Repositories;

use App\Models\Provider;
use App\Repositories\Interfaces\ProviderRepositoryInterface;

class ProviderRepository implements ProviderRepositoryInterface
{
    public function all()
    {
        return Provider::all();
    }

    public function store($data)
    {
        $providerData = array();
        $providerData['name'] = $data['name'];
        $providerData['address'] = $data['address'];
        $providerData['email'] = $data['email'];
        $providerData['phone'] = $data['mobile'];

        return Provider::create($providerData);
    }

    public function details($id)
    {
        return Provider::with('TrainingBatches')->where('id', '=', $id)->first();
    }

    public function find($id)
    {

        return Provider::find($id);
    }

    public function update($provider, $data)
    {
        $provider->update($data);
    }

    public function delete($id)
    {
        return Provider::find($id);
    }
}

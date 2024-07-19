<?php
namespace App\Domains\Provider\Interfaces;

interface ProviderServiceInterface
{
    public function getActiveList();

    public function getById(string $id = NULL);

    public function getCompleteList();

    public function saveProviderList($data);
    
    public function update(array $data, $id);
    
    public function delete($id);    
}
        
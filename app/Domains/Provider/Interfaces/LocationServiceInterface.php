<?php
namespace App\Domains\Provider\Interfaces;

interface LocationServiceInterface
{
    public function getActiveList();

    public function getById(string $id = NULL);

    public function getCompleteList();

    public function saveLocationList($data);
    
    public function update(array $data, $id);
    
    public function delete($id);        
}
        
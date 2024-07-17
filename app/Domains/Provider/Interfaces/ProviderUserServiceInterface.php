<?php
namespace App\Domains\Provider\Interfaces;

interface ProviderUserServiceInterface
{
    public function getActiveList();

    public function getById(string $id = NULL);

    public function getCompleteList();

    public function saveProviderUserList($data);
    
    public function update(array $data, $id);
    
    public function delete($id);    
}

<?php
namespace App\Domains\Franchise\Interfaces;

interface FranchiseServiceInterface
{
    public function getActiveList();

    public function getById(string $id = NULL);

    public function getCompleteList();

    public function saveFranchiseList($data);
    
    public function update(array $data, $id);
    
    public function delete($id);
}
        
<?php
namespace App\Domains\Product\Interfaces;

interface ProductServiceInterface
{
    public function getActiveList();

    public function getById(string $id = NULL);

    public function getCompleteList();

    public function saveProductList($data);
    
    public function update(array $data, $id);
    
    public function delete($id);
}
        
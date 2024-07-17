<?php
namespace App\Domains\Login\Interfaces;

interface LoginServiceInterface
{
    public function getActiveList();

    public function getById(string $id = NULL);

    public function getCompleteList();

    public function saveUserList($data);

    public function update(array $data, $id);

    public function delete($id);
}

<?php
namespace App\Domains\Provider\Services;

use App\Domains\Provider\Models\Product;
use App\Domains\Provider\Models\Providers;
use App\Domains\Provider\Models\ProviderUsers;
use App\Domains\Franchise\Models\Franchise;
use App\Repositories\Repository;
use App\Domains\Product\Interfaces\ProductServiceInterface;
use App\Domains\Franchise\Interfaces\FranchiseServiceInterface;
use App\Domains\Provider\Interfaces\ProviderServiceInterface;
use App\Domains\Provider\Interfaces\ProviderUserServiceInterface;
use Illuminate\Support\Facades\DB;

class ProviderUserService implements ProviderUserServiceInterface
{
    protected $model;
    public function __construct(ProviderUsers $provideruser)
    {
        // set the model
        $this->model = new Repository($provideruser);
    }

    public function getActiveList()
    {
        return json_encode($this->model::where('status', 1)->get());
    }

    public function getById(string $id = NULL)
    {
        return $this->model->show($id);
    }

    public function getCompleteList()
    {
        return $this->model->all();
    }

    public function saveProviderUserList($data)
    {
        $this->model->startTransaction();
        try {
            
            $resultResponse = $this->model->create($data);

        } catch (Exception $e) {

            $this->model->rollbackTransaction();

        }

        $this->model->completeTransaction();
        return $resultResponse;
    }
    
    public function update($data, $id)
    {
        $this->model->update($data, $id);
    }
    
    public function delete($id)
    {
        $this->model->delete($id);
    }  
}
        
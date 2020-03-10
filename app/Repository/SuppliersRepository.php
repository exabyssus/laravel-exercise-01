<?php

namespace App\Repository;

use App\Services\SoapService;
use Illuminate\Support\Collection;

class SuppliersRepository
{
    /**
     * @var SoapService
     */
    protected $service;

    /**
     * SuppliersRepository constructor.
     * @param SoapService $service
     */
    public function __construct(SoapService $service)
    {
        $this->service = $service;
    }

    /**
     * Retrieve suppliers from external API
     *
     * @param string $name
     * @throws \Exception
     * @return Collection
     */
    public function search($name = '')
    {
        $suppliers = collect();

                  $suppliers = $this->service->search($name);


        return $suppliers->filter(function ($item) use ($name){
            return $item->isActive && (stripos($item->supplierName, $name) !== false || stripos($item->registrationNumber, $name) !== false);
        });
    }
}

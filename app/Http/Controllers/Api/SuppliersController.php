<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\SuppliersRepository;
use Illuminate\Http\Request;

class SuppliersController extends Controller
{
    protected $suppliersRepository;

    public function __construct(SuppliersRepository $suppliersRepository)
    {
        $this->suppliersRepository = $suppliersRepository;
    }

    /**
     * Get supliers list by search term
     *
     * @param string $name Search term
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $name = $request->input('name');
        $suppliers = [];
            $suppliers = $this->suppliersRepository->search($name);

        try {
        } catch (\Exception $exception) {
            // Some logging functionality
        }

        return response()->json($suppliers);
    }
}

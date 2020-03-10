<?php

namespace App\Services;

use Artisaninweb\SoapWrapper\SoapWrapper;

class SoapService
{

    /**
     * @var SoapWrapper
     */
    protected $soapWrapper;

    /**
     * SoapController constructor.
     *
     * @param SoapWrapper $soapWrapper
     */
    public function __construct(SoapWrapper $soapWrapper)
    {
        $this->soapWrapper = $soapWrapper;
    }

    /**
     * Retrieve suppliers from external API
     *
     * @param string $name
     * @return \Illuminate\Support\Collection
     * @throws \Artisaninweb\SoapWrapper\Exceptions\ServiceAlreadyExists
     */
    public function search($name = '')
    {
        $this->soapWrapper->add('Suppliers', function ($service) {
            $service
                ->wsdl(config('services.soap.wsdl'))
                ->options([
                    'user_agent' => 'PHPSoapClient'
                ])
                ->trace(true);
        });

        $response = $this->soapWrapper->call('Suppliers.GetSuppliersList', [
            'GetSuppliersList' => [
                'MMIdentification' => [
                    'username' => config('services.soap.username'),
                    'password' => config('services.soap.password'),
                    'supplierEIC' => config('services.soap.eic'),
                    'messageId' => 'string'
                ]
            ]
        ]);

        return collect($response->suppliersList->SuppliersEntry);
    }
}

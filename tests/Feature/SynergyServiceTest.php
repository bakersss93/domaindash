<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Config;
use Tests\TestCase;
use Mockery;
use SoapFault;

class SynergyServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Ensure configuration uses local WSDL so SoapClient instantiation does not perform network calls
        Config::set('synergy.api_url', base_path('tests/fixtures/synergy.wsdl'));
        Config::set('synergy.reseller_id', 'test-reseller');
        Config::set('synergy.api_key', 'test-key');
    }

    protected function getSynergyWithMockClient($mock)
    {
        $synergy = app('synergy');

        $ref = new \ReflectionClass($synergy);
        $prop = $ref->getProperty('client');
        $prop->setAccessible(true);
        $prop->setValue($synergy, $mock);

        return $synergy;
    }

    public function test_check_domain_availability_invokes_correct_method(): void
    {
        $mock = Mockery::mock(\SoapClient::class);
        $mock->shouldReceive('__soapCall')
            ->once()
            ->with('CheckDomain', [[
                'resellerID' => 'test-reseller',
                'apiKey' => 'test-key',
                'domainName' => 'example.com',
            ]])
            ->andReturn((object)['available' => true]);

        $synergy = $this->getSynergyWithMockClient($mock);

        $result = $synergy->checkDomainAvailability('example.com');

        $this->assertEquals(['available' => true], $result);
    }

    public function test_check_domain_availability_handles_soap_fault(): void
    {
        $mock = Mockery::mock(\SoapClient::class);
        $mock->shouldReceive('__soapCall')
            ->once()
            ->andThrow(new SoapFault('Server', 'Unit test error'));

        $synergy = $this->getSynergyWithMockClient($mock);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('SOAP API Error: Unit test error');

        $synergy->checkDomainAvailability('example.com');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}

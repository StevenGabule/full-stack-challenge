<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

use Otto\Challenge;
use Otto\PdoBuilder;

/**
 * @testdox Challenge Class Tests
 */
class ChallengeTest extends TestCase
{
    protected $instance;
    protected $fixture;

    public function setUp(): void
    {
        $config = require_once __DIR__ . '/../config/database.config.php';

        $this->setInstance(new Challenge($config));
        $this->setFixture(include __DIR__ . '/fixtures/records.php');
    }

    /**
     * @testdox has an instance of the PdoBuilder class accessible to it
     */
    public function testClassHasInstanceOfPdoBuilder()
    {
        $pdoBuilderInstance = $this->getInstance()->getPdoBuilder();

        $this->assertEquals(PdoBuilder::class, get_class($pdoBuilderInstance));
    }

    /**
     * @testdox Can retrieve a set of director results
     */
    public function testGetDirectorRecords()
    {
        $directors = $this->getInstance()->getDirectorRecords();

        if(!$directors)
        {
            $this->fail("No results received");
        }

        $this->assertCount(1000, $directors);
        $this->assertIsArray($directors);
    }

    /**
     * @testdox Can retrieve a single director result with an id of 1
     */
    public function testGetSingleDirectorRecord()
    {
        $director = $this->getInstance()->getSingleDirectorRecord(1);

        $requiredKeys = [
            'id',
            'first_name',
            'last_name',
            'occupation',
            'date_of_birth'
        ];

        if(!$director)
        {
            $this->fail("No results received");
        }

        foreach($requiredKeys as $key)
        {
            $this->assertArrayHasKey($key, $director);
        }

        $this->assertIsArray($director);
        $this->assertEquals($director['id'], 1);
    }

    /**
     * @testdox Can retrieve a single director with a random id
     */
    public function testGetSingleDirectorRecordWithRandomId()
    {
        $randomId = rand(2, 1000);
        $director = $this->getInstance()->getSingleDirectorRecord($randomId);

        $requiredKeys = [
            'id',
            'first_name',
            'last_name',
            'occupation',
            'date_of_birth'
        ];

        if(!$director)
        {
            $this->fail("No results received");
        }

        foreach($requiredKeys as $key)
        {
            $this->assertArrayHasKey($key, $director);
        }

        $this->assertIsArray($director);
        $this->assertEquals($director['id'], $randomId);
    }

    /**
     * @testdox Can retrieve a set of business results
     */
    public function testGetBusinessRecords()
    {
        $businesses = $this->getInstance()->getBusinessRecords();

        if(!$businesses)
        {
            $this->fail("No results received");
        }

        $this->assertCount(1000, $businesses);
        $this->assertIsArray($businesses);
    }

    /**
     * @testdox Can retrieve a single business with an id of 1
     */
    public function testGetSingleBusinessRecord()
    {
        $business = $this->getInstance()->getSingleBusinessRecord(1);

        $requiredKeys = [
            'id',
            'name',
            'registered_address',
            'registration_date',
            'registration_number'
        ];

        if(!$business)
        {
            $this->fail("No results received");
        }

        foreach($requiredKeys as $key)
        {
            $this->assertArrayHasKey($key, $business);
        }

        $this->assertIsArray($business);
        $this->assertEquals($business['id'], 1);
    }

    /**
     * @testdox Can retrieve a single business with a random id
     */
    public function testGetSingleBusinessRecordWithRandomId()
    {
        $randomId = rand(2, 1000);
        $business = $this->getInstance()->getSingleBusinessRecord($randomId);

        $requiredKeys = [
            'id',
            'name',
            'registered_address',
            'registration_date',
            'registration_number'
        ];

        if(!$business)
        {
            $this->fail("No results received");
        }

        foreach($requiredKeys as $key)
        {
            $this->assertArrayHasKey($key, $business);
        }

        $this->assertIsArray($business);
        $this->assertEquals($business['id'], $randomId);
    }

    /**
     * @testdox Can retrieve a list of business names with the director name in a separate column
     */
    public function testGetBusinessNameWithDirectorFullNameTest()
    {
        $results = $this->getInstance()->getBusinessNameWithDirectorFullName();

        if(!$results)
        {
            $this->fail("No results received");
        }

        for($i = 0; $i < 1000; $i++)
        {
           $this->assertArrayHasKey('business_name', $results[$i]);
           $this->assertArrayHasKey('director_name', $results[$i]);
        }

        $this->assertIsArray($results);
        $this->assertCount(1000, $results);
    }

    /**
     * @testdox Can retrieve a list of businesses registered in 2005
     */
    public function testGetBusinessesRegisteredIn2005()
    {
        $results = $this->getInstance()->getBusinessesRegisteredInYear(2005);

        if(!$results)
        {
            $this->fail("No results received");
        }

        foreach($results as $result)
        {
            $this->assertArrayHasKey('id', $result);
            $this->assertArrayHasKey('name', $result);
            $this->assertArrayHasKey('registered_address', $result);
            $this->assertArrayHasKey('registration_date', $result);
            $this->assertArrayHasKey('registration_number', $result);
        }

        $this->assertIsArray($results);
        $this->assertCount(12, $results);
    }

    public function testCanGetLast100DirectorRecords()
    {
        $results = $this->getInstance()->getLast100Records();

        $requiredKeys = [
            'id',
            'first_name',
            'last_name',
            'occupation',
            'date_of_birth'
        ];

        if(!$results)
        {
            $this->fail("No results received");
        }

        foreach($results as $director)
        {
            foreach($requiredKeys as $key)
            {
                $this->assertArrayHasKey($key, $director);
            }
        }

        $this->assertIsArray($results);
        $this->assertCount(100, $results);
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setFixture(array $data)
    {
        $this->fixture = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function getFixture()
    {
        return $this->fixture;
    }

    /**
     * @param Main $instance
     * @return $this
     */
    public function setInstance(Challenge $instance)
    {
        $this->instance = $instance;
        return $this;
    }

    /**
     * @return Main
     */
    public function getInstance()
    {
        return $this->instance;
    }
}

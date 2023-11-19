<?php

namespace App\Tests\Entity;

const URL_API = '/api/equipment';
const ERROR_EQUIPMENT_ID = 'L\'ID de l\'équipement n\'est pas défini. Assurez-vous que le test de création a réussi.';
const APPLICATION_JSON = 'application/json';

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EquipmentTest extends WebTestCase
{
    private static ?int $equipmentId = null;

    public function testGetEquipmentCollection()
    {
        $client = static::createClient();
        $client->request('GET', URL_API);

        $this->assertResponseIsSuccessful();
        $content = $client->getResponse()->getContent();
        $this->assertJson($content);
    }

    public function testCreateEquipment()
    {
        $client = static::createClient();
        $data = [
            'name' => 'Test654987 Equipment',
            'category' => 'Test654987 Category',
            'number' => '654987',
            'description' => 'Test654987 Description',
        ];

        $client->request('POST', '/api/equipment', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
        $response = $client->getResponse();
        $responseData = json_decode($response->getContent(), true);
        self::$equipmentId = $responseData['id'];
    }

    public function testUpdateEquipment()
    {
        if (self::$equipmentId !== null) {
            $client = static::createClient();
            $data = [
                'name' => 'Updated Equipment',
                'category' => 'Updated Category',
                'number' => '543210',
                'description' => 'Updated Description',
            ];
            $client->request(
                'PUT',
                URL_API.'/'.self::$equipmentId,
                [],
                [],
                ['CONTENT_TYPE' => APPLICATION_JSON],
                json_encode($data)
            );
            $this->assertResponseIsSuccessful();
            $this->assertJson($client->getResponse()->getContent());
        } else {
            $this->markTestSkipped(ERROR_EQUIPMENT_ID);
        }
    }

    public function testPartialUpdateEquipment()
    {
        if (self::$equipmentId !== null) {
            $client = static::createClient();
            $data = [
                'name' => 'Updated Equipment 5321',
            ];
            $client->request(
                'PATCH',
                URL_API.'/'.self::$equipmentId,
                [],
                [],
                ['CONTENT_TYPE' => 'application/merge-patch+json'],
                json_encode($data)
            );
            $this->assertResponseIsSuccessful();
            $this->assertJson($client->getResponse()->getContent());
        } else {
            $this->markTestSkipped(ERROR_EQUIPMENT_ID);
        }
    }

    public function testDeleteEquipment()
    {
        if (self::$equipmentId !== null) {
            $client = static::createClient();
            $client->request('DELETE', URL_API.'/'.(self::$equipmentId-1));
            $this->assertResponseIsSuccessful();
        } else {
            $this->markTestSkipped(ERROR_EQUIPMENT_ID);
        }
    }
}

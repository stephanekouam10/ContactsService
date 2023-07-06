<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use PHPUnit\Framework\TestCase;

require __DIR__.'/../../src/ContactService.php';

/**
 * * @covers invalidInputException
 * @covers \ContactService
 *
 * @internal
 */
final class ContactServiceIntegrationTest extends TestCase
{
    private $contactService;

    public function __construct(string $name = null, array $data = [], $dataName = '') {
        parent::__construct($name, $data, $dataName);
        $this->contactService = new ContactService();
    }

    // test de suppression de toute les données, nécessaire pour nettoyer la bdd de tests à la fin
    public function testDeleteAll()
    {
        $this->contactService->createContact('abc', 'def');
        $this->contactService->createContact('abc', 'def');
        $this->contactService->createContact('abc', 'def');

        $this->contactService->deleteAllContact();
        $response = $this->contactService->getAllContacts();
        $this->assertIsArray($response);
        $this->assertEquals(0, count($response));
    }

    public function testGetAllContact()
    {
        $this->contactService->createContact('abc', 'def');
        $this->contactService->createContact('abc', 'def');
        $this->contactService->createContact('abc', 'def');

        $response = $this->contactService->getAllContacts();
        $this->assertIsArray($response);
        $this->assertEquals(3, count($response));
        $this->testDeleteAll();
    }

    public function testCreationContact()
    {
        $this->contactService->createContact('abcx', 'def');

        $response = $this->contactService->searchContact('abcx');
        $this->assertEquals('abcx', $response[0]['nom']);
        $this->testDeleteAll();
    }

    public function testSearchContact()
    {
        $this->contactService->createContact('abcx', 'def');
        $response = $this->contactService->searchContact('abcx');
        $this->assertIsArray($response);
        $this->assertEquals(1, count($response));
        $this->testDeleteAll();
    }

    public function testGetContact()
    {
        $this->contactService->createContact('abcx', 'def');
        $response = $this->contactService->getContact(1);
        $this->assertSame('abcx', $response["nom"]);
        $this->assertSame('def', $response["prenom"]);
        $this->testDeleteAll();
    }

    public function testModifyContact()
    {
        $this->contactService->createContact('abcx', 'def');
        $this->contactService->updateContact(1,'toto', 'tata');
        $response = $this->contactService->getContact(1);
        $this->assertSame('toto', $response["nom"]);
        $this->assertSame('tata', $response["prenom"]);
        $this->testDeleteAll();
    }

    public function testDeleteContact()
    {
        $this->contactService->createContact('abcx', 'def');
        $this->contactService->deleteContact(1);
        $response = $this->contactService->getAllContacts(1);
        $this->assertSame(0, count($response));
        $this->testDeleteAll();
    }

}

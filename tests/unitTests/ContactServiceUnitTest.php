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

require __DIR__ . '/../../src/ContactService.php';

/**
 * * @covers invalidInputException
 * @covers \ContactService
 *
 * @internal
 */
final class ContactServiceUnitTest extends TestCase {
    private $contactService;

    public function __construct(string $name = null, array $data = [], $dataName = '') {
        parent::__construct($name, $data, $dataName);
        $this->contactService = new ContactService();
    }

    public function testCreationContactWithoutAnyText() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("le nom  doit être renseigné");
        $this->contactService->createContact(null, null);
    }

    public function testCreationContactWithoutPrenom() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("le prenom doit être renseigné");
        $this->contactService->createContact("simo", null);
    }

    public function testCreationContactWithoutNom() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("le nom  doit être renseigné");
        $this->contactService->createContact(null, "gilles");
    }

    public function testCreationContactok() {
        $response = $this->contactService->createContact("simo", "gilles");
        $this->assertTrue($response);
    }

    public function testSearchContactWithNumber() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("search doit être une chaine de caractères");
        $this->contactService->searchContact(1234);
    }

    public function testSearchContactWithoutText() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("search doit être renseigné");
        $this->contactService->searchContact("");
    }

    public function testSearchContactOK() {
        $response = $this->contactService->searchContact("simo");
        $this->assertIsArray($response);
    }

    public function testModifyContactWithInvalidId() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("l'id doit être un entier non nul");
        $this->contactService->updateContact("abc", "adrien", "max");
    }

    public function testModifyContactWithIdUnderZero() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("l'id doit être un entier non nul");
        $this->contactService->updateContact("-1", "aserne", "jean");
    }

    public function testModifyContactWithoutId() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("l'id doit être renseigné");
        $this->contactService->updateContact(null, "jean", "alain");
    }

    public function testModifyContactWithoutInvalidName() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("le nom  doit être renseigné");
        $this->contactService->updateContact(1, null, "luc");
    }

    public function testModifyContactWithoutInvalidPrenom() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("le prenom doit être renseigné");
        $this->contactService->updateContact(1, "marc", null);
    }

    public function testModifyContactok() {
        $response = $this->contactService->updateContact(1, "martin", "white");
        $this->assertTrue($response);
    }

    public function testGetAllContacts() {
        $response = $this->contactService->getAllContacts();
        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
    }

    public function testGetContactWithInvalidNumber() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("l'id doit être un entier non nul");
        $this->contactService->getContact("abc");
    }

    public function testGetContactWithIdUnderZero() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("l'id doit être un entier non nul");
        $this->contactService->getContact(-1);
    }

    public function testGetContactWithoutId() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("l'id doit être renseigné");
        $this->contactService->getContact(null);
    }

    public function testGetContactOK() {
        $response = $this->contactService->getContact(1);
        $this->assertEquals("martin", $response["nom"]);
    }

    public function testDeleteContactWithTextAsId() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("l'id doit être un entier non nul");
        $this->contactService->deleteContact("abc");
    }

    public function testDeleteContactWithIdUnderZero() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("l'id doit être un entier non nul");
        $this->contactService->deleteContact(-1);
    }

    public function testDeleteContactWithIdNull() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("l'id doit être renseigné");
        $this->contactService->deleteContact(null);
    }

    public function testDeleteContactWithIdOk() {
        $response = $this->contactService->deleteContact(1);
        $this->assertTrue($response);
    }

    public function testDeleteContactAll() {
        $response = $this->contactService->deleteAllContact();
        $this->assertNotFalse($response);
    }
    
}

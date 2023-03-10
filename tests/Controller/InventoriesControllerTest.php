<?php

namespace App\Test\Controller;

use App\Entity\Inventories;
use App\Repository\InventoriesRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InventoriesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private InventoriesRepository $repository;
    private string $path = '/inventories/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Inventories::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Inventory index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'inventory[quantity]' => 'Testing',
            'inventory[product]' => 'Testing',
            'inventory[warehause]' => 'Testing',
        ]);

        self::assertResponseRedirects('/inventories/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Inventories();
        $fixture->setQuantity('My Title');
        $fixture->setProduct('My Title');
        $fixture->setWarehause('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Inventory');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Inventories();
        $fixture->setQuantity('My Title');
        $fixture->setProduct('My Title');
        $fixture->setWarehause('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'inventory[quantity]' => 'Something New',
            'inventory[product]' => 'Something New',
            'inventory[warehause]' => 'Something New',
        ]);

        self::assertResponseRedirects('/inventories/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getQuantity());
        self::assertSame('Something New', $fixture[0]->getProduct());
        self::assertSame('Something New', $fixture[0]->getWarehause());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Inventories();
        $fixture->setQuantity('My Title');
        $fixture->setProduct('My Title');
        $fixture->setWarehause('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/inventories/');
    }
}

<?php

namespace App\Test\Controller;

use App\Entity\Purchases;
use App\Repository\PurchasesRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PurchasesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PurchasesRepository $repository;
    private string $path = '/purchases/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Purchases::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Purchase index');

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
            'purchase[quantity]' => 'Testing',
            'purchase[unit_price]' => 'Testing',
            'purchase[purchace_date]' => 'Testing',
            'purchase[vendor]' => 'Testing',
            'purchase[product]' => 'Testing',
            'purchase[warehause]' => 'Testing',
        ]);

        self::assertResponseRedirects('/purchases/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Purchases();
        $fixture->setQuantity('My Title');
        $fixture->setUnit_price('My Title');
        $fixture->setPurchace_date('My Title');
        $fixture->setVendor('My Title');
        $fixture->setProduct('My Title');
        $fixture->setWarehause('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Purchase');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Purchases();
        $fixture->setQuantity('My Title');
        $fixture->setUnit_price('My Title');
        $fixture->setPurchace_date('My Title');
        $fixture->setVendor('My Title');
        $fixture->setProduct('My Title');
        $fixture->setWarehause('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'purchase[quantity]' => 'Something New',
            'purchase[unit_price]' => 'Something New',
            'purchase[purchace_date]' => 'Something New',
            'purchase[vendor]' => 'Something New',
            'purchase[product]' => 'Something New',
            'purchase[warehause]' => 'Something New',
        ]);

        self::assertResponseRedirects('/purchases/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getQuantity());
        self::assertSame('Something New', $fixture[0]->getUnit_price());
        self::assertSame('Something New', $fixture[0]->getPurchace_date());
        self::assertSame('Something New', $fixture[0]->getVendor());
        self::assertSame('Something New', $fixture[0]->getProduct());
        self::assertSame('Something New', $fixture[0]->getWarehause());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Purchases();
        $fixture->setQuantity('My Title');
        $fixture->setUnit_price('My Title');
        $fixture->setPurchace_date('My Title');
        $fixture->setVendor('My Title');
        $fixture->setProduct('My Title');
        $fixture->setWarehause('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/purchases/');
    }
}

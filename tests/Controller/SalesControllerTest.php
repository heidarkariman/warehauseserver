<?php

namespace App\Test\Controller;

use App\Entity\Sales;
use App\Repository\SalesRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SalesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private SalesRepository $repository;
    private string $path = '/sales/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Sales::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Sale index');

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
            'sale[quantity]' => 'Testing',
            'sale[unit_price]' => 'Testing',
            'sale[sale_date]' => 'Testing',
            'sale[customer]' => 'Testing',
            'sale[product]' => 'Testing',
            'sale[warehause]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sales/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Sales();
        $fixture->setQuantity('My Title');
        $fixture->setUnit_price('My Title');
        $fixture->setSale_date('My Title');
        $fixture->setCustomer('My Title');
        $fixture->setProduct('My Title');
        $fixture->setWarehause('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Sale');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Sales();
        $fixture->setQuantity('My Title');
        $fixture->setUnit_price('My Title');
        $fixture->setSale_date('My Title');
        $fixture->setCustomer('My Title');
        $fixture->setProduct('My Title');
        $fixture->setWarehause('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'sale[quantity]' => 'Something New',
            'sale[unit_price]' => 'Something New',
            'sale[sale_date]' => 'Something New',
            'sale[customer]' => 'Something New',
            'sale[product]' => 'Something New',
            'sale[warehause]' => 'Something New',
        ]);

        self::assertResponseRedirects('/sales/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getQuantity());
        self::assertSame('Something New', $fixture[0]->getUnit_price());
        self::assertSame('Something New', $fixture[0]->getSale_date());
        self::assertSame('Something New', $fixture[0]->getCustomer());
        self::assertSame('Something New', $fixture[0]->getProduct());
        self::assertSame('Something New', $fixture[0]->getWarehause());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Sales();
        $fixture->setQuantity('My Title');
        $fixture->setUnit_price('My Title');
        $fixture->setSale_date('My Title');
        $fixture->setCustomer('My Title');
        $fixture->setProduct('My Title');
        $fixture->setWarehause('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/sales/');
    }
}

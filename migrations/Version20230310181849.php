<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230310181849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customers (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address LONGTEXT DEFAULT NULL, phone_number VARCHAR(20) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventories (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, warehause_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_936C863D4584665A (product_id), INDEX IDX_936C863DBF9783 (warehause_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_categories (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_A99419434584665A (product_id), INDEX IDX_A994194312469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, price NUMERIC(13, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchases (id INT AUTO_INCREMENT NOT NULL, vendor_id INT NOT NULL, product_id INT NOT NULL, warehause_id INT NOT NULL, quantity INT NOT NULL, unit_price NUMERIC(13, 2) NOT NULL, purchace_date DATE NOT NULL, INDEX IDX_AA6431FEF603EE73 (vendor_id), INDEX IDX_AA6431FE4584665A (product_id), INDEX IDX_AA6431FEBF9783 (warehause_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sales (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, product_id INT NOT NULL, warehause_id INT NOT NULL, quantity INT NOT NULL, unit_price NUMERIC(13, 2) NOT NULL, sale_date DATE NOT NULL, INDEX IDX_6B8170449395C3F3 (customer_id), INDEX IDX_6B8170444584665A (product_id), INDEX IDX_6B817044BF9783 (warehause_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_roles (id INT AUTO_INCREMENT NOT NULL, userfk_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_54FCD59F82D32502 (userfk_id), INDEX IDX_54FCD59FD60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, firs_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vendors (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address LONGTEXT DEFAULT NULL, phone_number VARCHAR(20) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE warehauses (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inventories ADD CONSTRAINT FK_936C863D4584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE inventories ADD CONSTRAINT FK_936C863DBF9783 FOREIGN KEY (warehause_id) REFERENCES warehauses (id)');
        $this->addSql('ALTER TABLE product_categories ADD CONSTRAINT FK_A99419434584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE product_categories ADD CONSTRAINT FK_A994194312469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE purchases ADD CONSTRAINT FK_AA6431FEF603EE73 FOREIGN KEY (vendor_id) REFERENCES vendors (id)');
        $this->addSql('ALTER TABLE purchases ADD CONSTRAINT FK_AA6431FE4584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE purchases ADD CONSTRAINT FK_AA6431FEBF9783 FOREIGN KEY (warehause_id) REFERENCES warehauses (id)');
        $this->addSql('ALTER TABLE sales ADD CONSTRAINT FK_6B8170449395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id)');
        $this->addSql('ALTER TABLE sales ADD CONSTRAINT FK_6B8170444584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE sales ADD CONSTRAINT FK_6B817044BF9783 FOREIGN KEY (warehause_id) REFERENCES warehauses (id)');
        $this->addSql('ALTER TABLE user_roles ADD CONSTRAINT FK_54FCD59F82D32502 FOREIGN KEY (userfk_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_roles ADD CONSTRAINT FK_54FCD59FD60322AC FOREIGN KEY (role_id) REFERENCES roles (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inventories DROP FOREIGN KEY FK_936C863D4584665A');
        $this->addSql('ALTER TABLE inventories DROP FOREIGN KEY FK_936C863DBF9783');
        $this->addSql('ALTER TABLE product_categories DROP FOREIGN KEY FK_A99419434584665A');
        $this->addSql('ALTER TABLE product_categories DROP FOREIGN KEY FK_A994194312469DE2');
        $this->addSql('ALTER TABLE purchases DROP FOREIGN KEY FK_AA6431FEF603EE73');
        $this->addSql('ALTER TABLE purchases DROP FOREIGN KEY FK_AA6431FE4584665A');
        $this->addSql('ALTER TABLE purchases DROP FOREIGN KEY FK_AA6431FEBF9783');
        $this->addSql('ALTER TABLE sales DROP FOREIGN KEY FK_6B8170449395C3F3');
        $this->addSql('ALTER TABLE sales DROP FOREIGN KEY FK_6B8170444584665A');
        $this->addSql('ALTER TABLE sales DROP FOREIGN KEY FK_6B817044BF9783');
        $this->addSql('ALTER TABLE user_roles DROP FOREIGN KEY FK_54FCD59F82D32502');
        $this->addSql('ALTER TABLE user_roles DROP FOREIGN KEY FK_54FCD59FD60322AC');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE customers');
        $this->addSql('DROP TABLE inventories');
        $this->addSql('DROP TABLE product_categories');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE purchases');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE sales');
        $this->addSql('DROP TABLE user_roles');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE vendors');
        $this->addSql('DROP TABLE warehauses');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

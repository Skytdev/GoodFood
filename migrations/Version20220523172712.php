<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220523172712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, city_id INT DEFAULT NULL, number INT NOT NULL, channel VARCHAR(30) DEFAULT NULL, name VARCHAR(50) NOT NULL, INDEX IDX_D4E6F818BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE address_customer (address_id INT NOT NULL, customer_id INT NOT NULL, INDEX IDX_7FB67088F5B7AF75 (address_id), INDEX IDX_7FB670889395C3F3 (customer_id), PRIMARY KEY(address_id, customer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, franchise_id INT NOT NULL, discr VARCHAR(255) NOT NULL, INDEX IDX_23A0E66523CAB89 (franchise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, cp INT NOT NULL, name VARCHAR(50) NOT NULL, INDEX IDX_2D5B0234F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(180) NOT NULL, firstname VARCHAR(180) NOT NULL, birthday DATE NOT NULL, phone VARCHAR(15) NOT NULL, civility VARCHAR(10) NOT NULL, UNIQUE INDEX UNIQ_81398E09E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, franchise_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(180) NOT NULL, firstname VARCHAR(180) NOT NULL, birthday DATE NOT NULL, phone VARCHAR(15) NOT NULL, civility VARCHAR(10) NOT NULL, UNIQUE INDEX UNIQ_5D9F75A1E7927C74 (email), UNIQUE INDEX UNIQ_5D9F75A13124B5B6 (lastname), INDEX IDX_5D9F75A1523CAB89 (franchise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE extra (id INT AUTO_INCREMENT NOT NULL, ticket_row_id INT NOT NULL, ingredient_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_4D3F0D65F9E00339 (ticket_row_id), INDEX IDX_4D3F0D65933FE08C (ingredient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture_row (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, order_final_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_E1403B947294869C (article_id), INDEX IDX_E1403B94F22CF99C (order_final_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE franchise (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, address_id INT NOT NULL, name VARCHAR(50) NOT NULL, cost_delivery INT DEFAULT NULL, INDEX IDX_66F6CE2A3DA5256D (image_id), INDEX IDX_66F6CE2AF5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE franchise_franchise_category (franchise_id INT NOT NULL, franchise_category_id INT NOT NULL, INDEX IDX_6C3C1A0B523CAB89 (franchise_id), INDEX IDX_6C3C1A0B7F091F03 (franchise_category_id), PRIMARY KEY(franchise_id, franchise_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE franchise_city (franchise_id INT NOT NULL, city_id INT NOT NULL, INDEX IDX_EF731FFC523CAB89 (franchise_id), INDEX IDX_EF731FFC8BAC62AF (city_id), PRIMARY KEY(franchise_id, city_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE franchise_category (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, INDEX IDX_897CE23D3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient (id INT NOT NULL, name VARCHAR(50) NOT NULL, qte INT NOT NULL, unit VARCHAR(50) NOT NULL, stock_min INT NOT NULL, allergen VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient_product (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, ingredient_id INT NOT NULL, qte DOUBLE PRECISION NOT NULL, INDEX IDX_D27D0F6B4584665A (product_id), INDEX IDX_D27D0F6B933FE08C (ingredient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_object (id INT AUTO_INCREMENT NOT NULL, file_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, price INT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_7D053A933DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, state_id INT NOT NULL, customer_id INT NOT NULL, order_notice_id INT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_F52993985D83CC1 (state_id), INDEX IDX_F52993989395C3F3 (customer_id), UNIQUE INDEX UNIQ_F5299398BB523B53 (order_notice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_notice (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, score VARCHAR(255) NOT NULL, INDEX IDX_8B8255179395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_state (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_D34A04AD3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_product_category (product_id INT NOT NULL, product_category_id INT NOT NULL, INDEX IDX_437017AA4584665A (product_id), INDEX IDX_437017AABE6903FD (product_category_id), PRIMARY KEY(product_id, product_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_menu (product_id INT NOT NULL, menu_id INT NOT NULL, INDEX IDX_F0ED18324584665A (product_id), INDEX IDX_F0ED1832CCD7E912 (menu_id), PRIMARY KEY(product_id, menu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase (id INT AUTO_INCREMENT NOT NULL, supplier_id INT NOT NULL, created_at DATETIME NOT NULL, date_delivery DATETIME DEFAULT NULL, INDEX IDX_6117D13B2ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase_ingredient (id INT AUTO_INCREMENT NOT NULL, purchase_id INT NOT NULL, ingredient_id INT NOT NULL, qte DOUBLE PRECISION NOT NULL, unit_price DOUBLE PRECISION NOT NULL, INDEX IDX_679C2FBA558FBEB9 (purchase_id), INDEX IDX_679C2FBA933FE08C (ingredient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reduction (id INT AUTO_INCREMENT NOT NULL, menu_id INT DEFAULT NULL, product_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, start_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, level_priority INT DEFAULT NULL, discount_rate DOUBLE PRECISION DEFAULT NULL, INDEX IDX_B1E75468CCD7E912 (menu_id), INDEX IDX_B1E754684584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE refresh_tokens (id INT AUTO_INCREMENT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid DATETIME NOT NULL, UNIQUE INDEX UNIQ_9BACE7E1C74F2195 (refresh_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supplier (id INT AUTO_INCREMENT NOT NULL, address_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_9B2A6C7EF5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supplier_franchise (supplier_id INT NOT NULL, franchise_id INT NOT NULL, INDEX IDX_FCC4F4F42ADD6D8C (supplier_id), INDEX IDX_FCC4F4F4523CAB89 (franchise_id), PRIMARY KEY(supplier_id, franchise_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_row (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, order_final_id INT NOT NULL, INDEX IDX_87492DF74584665A (product_id), INDEX IDX_87492DF7F22CF99C (order_final_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F818BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE address_customer ADD CONSTRAINT FK_7FB67088F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE address_customer ADD CONSTRAINT FK_7FB670889395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id)');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id)');
        $this->addSql('ALTER TABLE extra ADD CONSTRAINT FK_4D3F0D65F9E00339 FOREIGN KEY (ticket_row_id) REFERENCES ticket_row (id)');
        $this->addSql('ALTER TABLE extra ADD CONSTRAINT FK_4D3F0D65933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id)');
        $this->addSql('ALTER TABLE facture_row ADD CONSTRAINT FK_E1403B947294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE facture_row ADD CONSTRAINT FK_E1403B94F22CF99C FOREIGN KEY (order_final_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE franchise ADD CONSTRAINT FK_66F6CE2A3DA5256D FOREIGN KEY (image_id) REFERENCES media_object (id)');
        $this->addSql('ALTER TABLE franchise ADD CONSTRAINT FK_66F6CE2AF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE franchise_franchise_category ADD CONSTRAINT FK_6C3C1A0B523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE franchise_franchise_category ADD CONSTRAINT FK_6C3C1A0B7F091F03 FOREIGN KEY (franchise_category_id) REFERENCES franchise_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE franchise_city ADD CONSTRAINT FK_EF731FFC523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE franchise_city ADD CONSTRAINT FK_EF731FFC8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE franchise_category ADD CONSTRAINT FK_897CE23D3DA5256D FOREIGN KEY (image_id) REFERENCES media_object (id)');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF7870BF396750 FOREIGN KEY (id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ingredient_product ADD CONSTRAINT FK_D27D0F6B4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE ingredient_product ADD CONSTRAINT FK_D27D0F6B933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A933DA5256D FOREIGN KEY (image_id) REFERENCES media_object (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93BF396750 FOREIGN KEY (id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993985D83CC1 FOREIGN KEY (state_id) REFERENCES order_state (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398BB523B53 FOREIGN KEY (order_notice_id) REFERENCES order_notice (id)');
        $this->addSql('ALTER TABLE order_notice ADD CONSTRAINT FK_8B8255179395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD3DA5256D FOREIGN KEY (image_id) REFERENCES media_object (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADBF396750 FOREIGN KEY (id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_product_category ADD CONSTRAINT FK_437017AA4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_product_category ADD CONSTRAINT FK_437017AABE6903FD FOREIGN KEY (product_category_id) REFERENCES product_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_menu ADD CONSTRAINT FK_F0ED18324584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_menu ADD CONSTRAINT FK_F0ED1832CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE purchase_ingredient ADD CONSTRAINT FK_679C2FBA558FBEB9 FOREIGN KEY (purchase_id) REFERENCES purchase (id)');
        $this->addSql('ALTER TABLE purchase_ingredient ADD CONSTRAINT FK_679C2FBA933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id)');
        $this->addSql('ALTER TABLE reduction ADD CONSTRAINT FK_B1E75468CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE reduction ADD CONSTRAINT FK_B1E754684584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE supplier ADD CONSTRAINT FK_9B2A6C7EF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE supplier_franchise ADD CONSTRAINT FK_FCC4F4F42ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE supplier_franchise ADD CONSTRAINT FK_FCC4F4F4523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ticket_row ADD CONSTRAINT FK_87492DF74584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE ticket_row ADD CONSTRAINT FK_87492DF7F22CF99C FOREIGN KEY (order_final_id) REFERENCES `order` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address_customer DROP FOREIGN KEY FK_7FB67088F5B7AF75');
        $this->addSql('ALTER TABLE franchise DROP FOREIGN KEY FK_66F6CE2AF5B7AF75');
        $this->addSql('ALTER TABLE supplier DROP FOREIGN KEY FK_9B2A6C7EF5B7AF75');
        $this->addSql('ALTER TABLE facture_row DROP FOREIGN KEY FK_E1403B947294869C');
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF7870BF396750');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93BF396750');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADBF396750');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F818BAC62AF');
        $this->addSql('ALTER TABLE franchise_city DROP FOREIGN KEY FK_EF731FFC8BAC62AF');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B0234F92F3E70');
        $this->addSql('ALTER TABLE address_customer DROP FOREIGN KEY FK_7FB670889395C3F3');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993989395C3F3');
        $this->addSql('ALTER TABLE order_notice DROP FOREIGN KEY FK_8B8255179395C3F3');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66523CAB89');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1523CAB89');
        $this->addSql('ALTER TABLE franchise_franchise_category DROP FOREIGN KEY FK_6C3C1A0B523CAB89');
        $this->addSql('ALTER TABLE franchise_city DROP FOREIGN KEY FK_EF731FFC523CAB89');
        $this->addSql('ALTER TABLE supplier_franchise DROP FOREIGN KEY FK_FCC4F4F4523CAB89');
        $this->addSql('ALTER TABLE franchise_franchise_category DROP FOREIGN KEY FK_6C3C1A0B7F091F03');
        $this->addSql('ALTER TABLE extra DROP FOREIGN KEY FK_4D3F0D65933FE08C');
        $this->addSql('ALTER TABLE ingredient_product DROP FOREIGN KEY FK_D27D0F6B933FE08C');
        $this->addSql('ALTER TABLE purchase_ingredient DROP FOREIGN KEY FK_679C2FBA933FE08C');
        $this->addSql('ALTER TABLE franchise DROP FOREIGN KEY FK_66F6CE2A3DA5256D');
        $this->addSql('ALTER TABLE franchise_category DROP FOREIGN KEY FK_897CE23D3DA5256D');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A933DA5256D');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD3DA5256D');
        $this->addSql('ALTER TABLE product_menu DROP FOREIGN KEY FK_F0ED1832CCD7E912');
        $this->addSql('ALTER TABLE reduction DROP FOREIGN KEY FK_B1E75468CCD7E912');
        $this->addSql('ALTER TABLE facture_row DROP FOREIGN KEY FK_E1403B94F22CF99C');
        $this->addSql('ALTER TABLE ticket_row DROP FOREIGN KEY FK_87492DF7F22CF99C');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398BB523B53');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993985D83CC1');
        $this->addSql('ALTER TABLE ingredient_product DROP FOREIGN KEY FK_D27D0F6B4584665A');
        $this->addSql('ALTER TABLE product_product_category DROP FOREIGN KEY FK_437017AA4584665A');
        $this->addSql('ALTER TABLE product_menu DROP FOREIGN KEY FK_F0ED18324584665A');
        $this->addSql('ALTER TABLE reduction DROP FOREIGN KEY FK_B1E754684584665A');
        $this->addSql('ALTER TABLE ticket_row DROP FOREIGN KEY FK_87492DF74584665A');
        $this->addSql('ALTER TABLE product_product_category DROP FOREIGN KEY FK_437017AABE6903FD');
        $this->addSql('ALTER TABLE purchase_ingredient DROP FOREIGN KEY FK_679C2FBA558FBEB9');
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13B2ADD6D8C');
        $this->addSql('ALTER TABLE supplier_franchise DROP FOREIGN KEY FK_FCC4F4F42ADD6D8C');
        $this->addSql('ALTER TABLE extra DROP FOREIGN KEY FK_4D3F0D65F9E00339');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE address_customer');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE extra');
        $this->addSql('DROP TABLE facture_row');
        $this->addSql('DROP TABLE franchise');
        $this->addSql('DROP TABLE franchise_franchise_category');
        $this->addSql('DROP TABLE franchise_city');
        $this->addSql('DROP TABLE franchise_category');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE ingredient_product');
        $this->addSql('DROP TABLE media_object');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_notice');
        $this->addSql('DROP TABLE order_state');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_product_category');
        $this->addSql('DROP TABLE product_menu');
        $this->addSql('DROP TABLE product_category');
        $this->addSql('DROP TABLE purchase');
        $this->addSql('DROP TABLE purchase_ingredient');
        $this->addSql('DROP TABLE reduction');
        $this->addSql('DROP TABLE refresh_tokens');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('DROP TABLE supplier_franchise');
        $this->addSql('DROP TABLE ticket_row');
    }
}

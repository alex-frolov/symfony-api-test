<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\Locales;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211129115311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, INDEX IDX_CBE5A331F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331F675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
        $this->addSql("CREATE TABLE `book_locale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `locale` enum('en','ru') NOT NULL DEFAULT 'en',
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `book_id_locale` (`book_id`,`locale`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        $this->addSql('ALTER TABLE book_locale ADD CONSTRAINT FK_6857CD1516A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->makeAuthors();
        $this->makeBooks();
        $this->makeBookLocales();

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_locale DROP FOREIGN KEY FK_6857CD1516A2B381');
        $this->addSql('DROP TABLE book_locale');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331F675F31B');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE book');
    }

    private function makeAuthors()
    {
        $sqlHeader = "INSERT INTO author (id, name) VALUES ";
        $sql = $sqlHeader;
        $cnt = 0;
        for ($i = 1; $i <= 10000; $i++) {
            if ($cnt > 0) {
                $sql .= ',';
            }
            $cnt++;
            $sql .= "($i, '" . $this->generateName('author') . "')";

            if (500 < $cnt) {
                $this->addSql($sql);
                $cnt = 0;
                $sql = $sqlHeader;
            }
        }

        if ($cnt > 0) {
            $this->addSql($sql);
        }
    }

    private function makeBooks()
    {
        $sqlHeader = "INSERT INTO book (author_id) VALUES ";
        $sql = $sqlHeader;
        $cnt = 0;
        for ($i = 1; $i <= 10000; $i++) {
            if ($cnt > 0) {
                $sql .= ',';
            }
            $cnt++;
            $sql .= "($i)";

            if (500 < $cnt) {
                $this->addSql($sql);
                $cnt = 0;
                $sql = $sqlHeader;
            }
        }

        if ($cnt > 0) {
            $this->addSql($sql);
        }
    }

    private function makeBookLocales()
    {
        $sqlHeader = "INSERT INTO book_locale (book_id, locale, name) VALUES ";
        $sql = $sqlHeader;
        $cnt = 0;
        $locales = [Locales::EN, Locales::RU];
        for ($i = 1; $i <= 10000; $i++) {
            if ($cnt > 0) {
                $sql .= ',';
            }
            $cnt++;
            $sql .= "($i, '" . Locales::EN . "', '" . $this->generateName('book') . "')";
            $sql .= ",($i, '" . Locales::RU . "', '" . $this->generateRuName('книга_') . "')";

            if (500 < $cnt) {
                $this->addSql($sql);
                $cnt = 0;
                $sql = $sqlHeader;
            }
        }

        if ($cnt > 0) {
            $this->addSql($sql);
        }
    }

    private function generateRuName(string $prefix): string
    {
        return $prefix . '_название ' . rand(1000, 100000) . time();
    }

    private function generateName(string $prefix): string
    {
        return $prefix . 'name ' . rand(1000, 100000) . time();
    }

}

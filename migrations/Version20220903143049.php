<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220903143049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE album_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE artiste_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE label_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE style_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE album (id INT NOT NULL, label_id INT DEFAULT NULL, date_sortie TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_39986E4333B92F39 ON album (label_id)');
        $this->addSql('CREATE TABLE album_artiste (album_id INT NOT NULL, artiste_id INT NOT NULL, PRIMARY KEY(album_id, artiste_id))');
        $this->addSql('CREATE INDEX IDX_C9D0685D1137ABCF ON album_artiste (album_id)');
        $this->addSql('CREATE INDEX IDX_C9D0685D21D25844 ON album_artiste (artiste_id)');
        $this->addSql('CREATE TABLE artiste (id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, albums VARCHAR(255) NOT NULL, styles VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON TABLE artiste IS \'Table des Artistes\'');
        $this->addSql('COMMENT ON COLUMN artiste.nom IS \'Nom de l\\\'\'artiste\'');
        $this->addSql('COMMENT ON COLUMN artiste.prenom IS \'Prenom de l\\\'\'artiste\'');
        $this->addSql('COMMENT ON COLUMN artiste.date_naissance IS \'Date de naissance de l\\\'\'artiste\'');
        $this->addSql('COMMENT ON COLUMN artiste.albums IS \'Albums de l\\\'\'artiste\'');
        $this->addSql('COMMENT ON COLUMN artiste.styles IS \'Styles de l\\\'\'artiste\'');
        $this->addSql('CREATE TABLE label (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE style (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE style_album (style_id INT NOT NULL, album_id INT NOT NULL, PRIMARY KEY(style_id, album_id))');
        $this->addSql('CREATE INDEX IDX_F34D20B8BACD6074 ON style_album (style_id)');
        $this->addSql('CREATE INDEX IDX_F34D20B81137ABCF ON style_album (album_id)');
        $this->addSql('CREATE TABLE style_artiste (style_id INT NOT NULL, artiste_id INT NOT NULL, PRIMARY KEY(style_id, artiste_id))');
        $this->addSql('CREATE INDEX IDX_FA2BAB7BBACD6074 ON style_artiste (style_id)');
        $this->addSql('CREATE INDEX IDX_FA2BAB7B21D25844 ON style_artiste (artiste_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E4333B92F39 FOREIGN KEY (label_id) REFERENCES label (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE album_artiste ADD CONSTRAINT FK_C9D0685D1137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE album_artiste ADD CONSTRAINT FK_C9D0685D21D25844 FOREIGN KEY (artiste_id) REFERENCES artiste (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE style_album ADD CONSTRAINT FK_F34D20B8BACD6074 FOREIGN KEY (style_id) REFERENCES style (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE style_album ADD CONSTRAINT FK_F34D20B81137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE style_artiste ADD CONSTRAINT FK_FA2BAB7BBACD6074 FOREIGN KEY (style_id) REFERENCES style (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE style_artiste ADD CONSTRAINT FK_FA2BAB7B21D25844 FOREIGN KEY (artiste_id) REFERENCES artiste (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE album_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE artiste_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE label_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE style_id_seq CASCADE');
        $this->addSql('ALTER TABLE album DROP CONSTRAINT FK_39986E4333B92F39');
        $this->addSql('ALTER TABLE album_artiste DROP CONSTRAINT FK_C9D0685D1137ABCF');
        $this->addSql('ALTER TABLE album_artiste DROP CONSTRAINT FK_C9D0685D21D25844');
        $this->addSql('ALTER TABLE style_album DROP CONSTRAINT FK_F34D20B8BACD6074');
        $this->addSql('ALTER TABLE style_album DROP CONSTRAINT FK_F34D20B81137ABCF');
        $this->addSql('ALTER TABLE style_artiste DROP CONSTRAINT FK_FA2BAB7BBACD6074');
        $this->addSql('ALTER TABLE style_artiste DROP CONSTRAINT FK_FA2BAB7B21D25844');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE album_artiste');
        $this->addSql('DROP TABLE artiste');
        $this->addSql('DROP TABLE label');
        $this->addSql('DROP TABLE style');
        $this->addSql('DROP TABLE style_album');
        $this->addSql('DROP TABLE style_artiste');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Artiste;
use App\Entity\Departement;
use App\Entity\Festival;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $departments = [
            'Charente (16)',
            'Charente-Maritime (17)',
            'Corrèze (19)',
            'Creuse (23)',
            'Dordogne (24)',
            'Gironde (33)',
            'Landes (40)',
            'Lot-et-Garonne (47)',
            'Pyrénées-Atlantiques (64)',
            'Deux-Sèvres (79)',
            'Vienne (86)',
            'Haute-Vienne (87)'
        ];

        foreach ($departments as $deptName) {
            $department = new Departement();
            $department->setName($deptName);
            $manager->persist($department);
        }

        $artists = [
            ['name' => 'Houssem', 'style' => 'Classique'],
            ['name' => 'Linh', 'style' => 'JPop'],
            ['name' => 'Sylvain', 'style' => 'Rap'],
        ];

        foreach ($artists as $artistData) {
            $artist = new Artiste();
            $artist->setName($artistData['name']);
            $artist->setStyle($artistData['style']);
            $manager->persist($artist);
        }

        $manager->flush();

        for ($i = 1; $i <= 5; $i++) {
            $festival = new Festival();
            $festival->setName('Festival ' . $i);
            $festival->setDate(new \DateTime('2023-09-15'));

            $artists = $manager->getRepository(Artiste::class)->findAll();
            shuffle($artists);
            $selectedArtists = array_slice($artists, 0, 3);

            foreach ($selectedArtists as $artist) {
                $festival->addArtiste($artist);
            }


            $departments = $manager->getRepository(Departement::class)->findAll();
            shuffle($departments);
            $selectedDepartments = array_slice($departments, 0, 2);

            foreach ($selectedDepartments as $department) {
                $festival->setDepartement($department);
            }

            $manager->persist($festival);
        }
        $manager->flush();
    }
}

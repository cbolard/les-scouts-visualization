<?php

namespace App\DataFixtures;

use App\Entity\WsBranche;
use App\Entity\WsFederation;
use App\Entity\WsGroupeUnite;
use App\Entity\WsMembre;
use App\Entity\WsSection;
use App\Entity\WsUnite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $manager;

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->generateLS();
        $manager->flush();
    }

    protected function generateLS()
    {
        $faker = Factory::create('fr_BE');

        $lesscouts = new WsFederation();

        $lesscouts->setName("Les Scouts");

        $this->manager->persist($lesscouts);

        $branchesCodes = [
            1=> ['name' => 'Baladins', 'code' => 'B'],
            2=> ['name' => 'Louveteaux', 'code' => 'L'],
            3=> ['name' => 'Eclaireurs', 'code' => 'E'],
            4=> ['name' => 'Pionniers', 'code' => 'P']
        ];
        $groupes = [
            1 => ['code' => 'AFV', 'name' => 'Au fil de la Vesdre'],
            2 => ['code' => 'ARD', 'name' => 'Ardenne'],
            3 => ['code' => 'BAB', 'name' => 'Bruxelles-Abbayes'],
            4 => ['code' => 'BAL', 'name' => 'Bruxelles-Altitude'],
            5 => ['code' => 'BLC', 'name' => 'Bruxelles-Longchamp'],
            6 => ['code' => 'BRU', 'name' => 'Brunehault'],
            7 => ['code' => 'BWL', 'name' => 'Bruxelles-Woluwe'],
            8 => ['code' => 'BXA', 'name' => 'Bruxelles-Arcades'],
            9 => ['code' => 'BXB', 'name' => 'Bruxelles-Buda'],
            10 => ['code' => 'BZO', 'name' => 'Bruxelles-Zénith Ouest'],
            11 => ['code' => 'CHR', 'name' => 'Charleroi'],
            12 => ['code' => 'CHT', 'name' => 'Chantoirs'],
            13 => ['code' => 'ESC', 'name' => 'Escaut'],
            14 => ['code' => 'ESO', 'name' => 'Entre-Sambre-Orneau'],
            15 => ['code' => 'GML', 'name' => 'Gaume-Lorraine'],
            16 => ['code' => 'HBE', 'name' => 'Hesbaye Est'],
            17 => ['code' => 'HED', 'name' => 'Haine et Dendre'],
            18 => ['code' => 'HHS', 'name' => 'Hohe Seen'],
            19 => ['code' => 'HOU', 'name' => 'Hainaut-Ouest'],
            20 => ['code' => 'LBM', 'name' => 'Liège Basse-Meuse'],
            21 => ['code' => 'LRD', 'name' => 'Liège-Rive droite'],
            22 => ['code' => 'LRG', 'name' => 'Liège-Rive gauche'],
            23 => ['code' => 'LSM', 'name' => 'Les Sept Meuse'],
            24 => ['code' => 'LTR', 'name' => 'Les Trois Rivières'],
            25 => ['code' => 'L3', 'name' => 'LIEGE 3'],
            26 => ['code' => 'NAV', 'name' => 'Namur-Vallées'],
            27 => ['code' => 'OET', 'name' => 'Orne et Thyle'],
            28 => ['code' => 'PDH', 'name' => 'Pays de Herve'],
            29 => ['code' => 'ROP', 'name' => 'Roman Païs'],
            30 => ['code' => 'THI', 'name' => 'Thiérache'],
            31 => ['code' => 'TRE', 'name' => 'Terrils-Est'],
            32 => ['code' => 'TRO', 'name' => 'Terrils-Ouest'],
            33 => ['code' => 'TSL', 'name' => 'Terre de sources et de légendes'],
            34 => ['code' => 'VBB', 'name' => 'Vert Brabant'],
            35 => ['code' => 'VDM', 'name' => 'Vallée Dyle-Mazerine'],
            36 => ['code' => 'VMH', 'name' => 'Val mosan-Huy'],
            37 => ['code' => 'VML', 'name' => 'Val mosan-Liège'],
        ];
        $branches = [];
        for ($b = 1; $b<5; $b++)
        {
            $branche = new WsBranche();
            $branche->setName($branchesCodes[$b]['name']);
            $branche->setValue($branchesCodes[$b]['code']);
            $branches[$b] = $branche;
            $this->manager->persist($branche);
            $this->manager->flush();
        }

        for ($i = 1; $i<10; $i++)
        {
            $groupe = new WsGroupeUnite();
            $groupe->setFederation($lesscouts);
            $groupe->setName($groupes[$i]['name']);
            $groupe->setValue($groupes[$i]['code']);
            $this->manager->persist($groupe);
            $this->manager->flush();
            for ($a = 1; $a<5; $a++)
            {
                $unite = new WsUnite();
                $unite->setGroupe($groupe);
                $letters = strtoupper($faker->lexify('??'));
                $numbers = $faker->numerify('##');
                $name = $letters . '0' . $numbers;
                $unite->setValue($name);
                $unite->setName($faker->city());
                $this->manager->persist($unite);
                $this->manager->flush();
                for ($j = 1; $j<5; $j++)
                {
                    $section = new WsSection();
                    $section->setBranche($branches[$j]);
                    $section->setValue($unite->getValue().$branches[$j]->getValue());
                    $section->setName($unite->getValue()." ".$branches[$j]->getName());
                    $section->setUnite($unite);
                    $this->manager->persist($section);
                    $this->manager->flush();
                    for ($k = 1; $k<rand(5,15); $k++)
                    {
                        $membre = new WsMembre();
                        $membre->setSection($section);
                        $membre->setEmail($faker->email());
                        $membre->setNom($faker->lastName());
                        $membre->setPrenom($faker->firstName());
                        $this->manager->persist($membre);
                        $this->manager->flush();
                    }
                }
            }
        }

    }
}
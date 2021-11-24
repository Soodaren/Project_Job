<?php

namespace App\Service;

use App\Entity\Album;
use App\Entity\Artist;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MusicService
{

    const TOKEN = "BQDme-2OwqLiB3d6v3mFK93BiIiv63INqhtzweGUE8B_8TvG_RWF_m3Hk9eVPzz_NRWBpZe9eYMurvnQi9xA0r-3bYR--9M5R7LL_rO-W8sYN3mQoGM3ZVOuBqfVX6ynzGbsnXVdNALW03c_0YBpJ2tR7cuMX64";
    const URL = "https://api.spotify.com/";

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ParameterBagInterface
     */
    private $parameterBag;

    /**
     * @param EntityManagerInterface $entityManager
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ParameterBagInterface  $parameterBag)
    {
        $this->em = $entityManager;
        $this->parameterBag = $parameterBag;
    }

    /**
     * @throws GuzzleException
     */
    public function getMusic(): array
    {
        $client = new Client(['base_uri' => self::URL]);

        $response = $client->request(
            'GET',
            'v1/albums?ids=382ObEPsp2rxGrnsizN5TX%2C1A2GTWGtFfWp7KSQTwWOyo%2C2noRn2Aes5aoNVsU6iWThc&market=ES',
            ['headers' => [
                'Authorization' => 'Bearer ' . self::TOKEN,
                'Accept' => 'application/json',
            ]]
        )->getBody()->getContents();

        return json_decode($response, true);

    }

    /**
     * @param $output
     * @return array|void
     * @throws GuzzleException
     */
    public function fetchArtistDetails($output)
    {
        try {
            return $this
                ->getMusic();
        } catch (\Exception $exception) {
            $output->writeln(['Artist Details fetched from api failed, exit']);

        }
    }

    public function checkIfArtistExists($artistName): array
    {
        return
            $this
                ->em
                ->getRepository(Artist::class)
                ->findBy([
                    'name' => $artistName
                ]);
    }

    public function saveArtist($artistDetails)
    {
        //loop in array albums
        foreach ($artistDetails['albums'] as $tracks) {
            $items = $tracks['tracks'];

            //loop in array items
            foreach ($items['items'] as $artists) {

                //loop in array artists
                foreach ($artists['artists'] as $artist) {
//                    dd($artists['artists']);
                    $name = $artist['name'];
                    $artist = new Artist();
                    $artist->setName($name);
                    $this->em->persist($artist);
                }
            }
        }
        $this->em->flush();
    }

    public function updateArtist()
    {

    }

    /**
     * @param $output
     * @return array|false
     * @throws GuzzleException
     */

    //Retrieve data from api
    public function fetchAlbumDetails($output)
    {
        try {
            return $this
                ->getMusic();
        } catch (\Exception $exception) {
            $output->writeln(['Album Details fetched from api failed, exit']);

            return false;
        }
    }

    //Check if album exists by title
    public function checkIfAlbumExists($albumTitle): array
    {
        return
            $this
                ->em
                ->getRepository(Album::class)
                ->findBy([
                    'title' => $albumTitle
                ]);
    }

    //save api data in DB
    public function saveAlbum($albumDetails)
    {
        //loop in array albums to retrieve release date,name,total tracks
        foreach ($albumDetails['albums'] as $albums) {
            $releaseDate = $albums['release_date'];
            $title = $albums['name'];
            $totalTracks = $albums['total_tracks'];

            //loop in array images found array albums to retrieve image
            foreach ($albums['images'] as $images) {
                $image = $images['url'];
            }

            $date = \DateTime::createFromFormat('Y-m-d', $releaseDate);

            $album = new Album();
            $album->setTitle($title);
            $album->setTotalTracks($totalTracks);
            $album->setReleaseDate($date);

            $posterName = uniqid() . '.jpg';

            $content = file_get_contents($image);
            $fp = fopen($this->parameterBag->get('kernel.project_dir') . "/public/images/" . $posterName, "w");
            fwrite($fp, $content);
            fclose($fp);

            $album->setPoster($posterName);

            $this->em->persist($album);

        }
        $this->em->flush();
    }
}
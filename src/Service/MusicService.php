<?php

namespace App\Service;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Music;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MusicService
{

    const TOKEN = "BQDBhaZs2xsPlVHV26nyk58oVjrzaCoesk9G51X7ywvXGKQbEv2D8yV3JBZ-xZ4pxb7hcpcdJ6BgbLw3AKIaJVCFiLNOfj2RInP6rhZo-GMtyFDHQ1l89NyhlGJwoc-wlg1-b80qwGfxXgqscqz5Ctn3P1Cftag";
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

    public function getArtistById($id): bool
    {
        return !empty(
        $this
            ->em
            ->getRepository(Artist::class)
            ->findById($id));
    }

    public function saveArtist($artistDetails)
    {
        //loop in array albums
        foreach ($artistDetails['albums'] as $album) {
            $items = $album['tracks'];

            //loop in array items
            foreach ($items['items'] as $artists) {

                //loop in array artists
                foreach ($artists['artists'] as $artist) {

                    $idol = new Artist();
                    $idol->setName($artist['name']);
                    $idol->setArtistId($artist['id']);
                    $this->em->persist($idol);
                }
            }
        }
        $this->em->flush();
    }

    public function updateArtist($artist)
    {
        $id = $artist['id'];
        $name = $artist['name'];

        $result = $this
            ->em
            ->getRepository(Artist::class)
            ->findById($id);

        $result->setName($name);
        $result->setArtistId($id);
        $this->em->persist($result);
        $this->em->flush();

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
    public function getAlbumByTitle($albumTitle)
    {
        return
            $this
                ->em
                ->getRepository(Album::class)
                ->findOneBy([
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

    /**
     * @param $output
     * @return array|false
     * @throws GuzzleException
     */
    public function fetchMusicDetails($output)
    {
        try {
            return $this
                ->getMusic();
        } catch (\Exception $exception) {
            $output->writeln(['Album Details fetched from api failed, exit']);

            return false;
        }
    }

    public function getMusicById($id): bool
    {
        return !empty(
        $this
            ->em
            ->getRepository(Music::class)
            ->findById($id));
    }

    public function saveMusic($musicDetails)
    {
        foreach ($musicDetails['albums'] as $album) {

            $items = $album['tracks'];
            $albumObj = $this->getAlbumByTitle($album['name']);
            foreach ($items['items'] as $track) {

                $title = $track['name'];
                $duration = $track['duration_ms'];
                $id = $track['id'];
                $music = new Music();
                $music->setTitle($title);
                $music->setDuration($duration);
                $music->setAlbum($albumObj);
                $music->setMusicId($id);
                $this->em->persist($music);
            }
        }
        $this->em->flush();
    }

    public function updateMusic($music){

        $id = $music['id'];
        $title = $music['title'];
        $duration = $music['duration'];

        $result = $this
            ->em
            ->getRepository(Music::class)
            ->findById($id);

        $result->setTitle($title);
        $result->setMusicId($id);
        $result->setDuration($duration);
        $this->em->persist($result);
        $this->em->flush();
    }
}
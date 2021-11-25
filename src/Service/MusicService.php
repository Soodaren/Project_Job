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

    const TOKEN = "BQCAtPu255mMLDo1zoxwz2omVd-A0-QonUlj_Q_GqqDI8DN-FtaaQhhrZBshI6m7W-UgmUbhTSd0zSe3Bml5rqPi3WAg1zwwmziYiIy6-nh0uD1_SCSlBWBTk0d62RfZ2oRH61yx3IvQRvkSUNXni6izWXME8LM";
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

    public function getArtistByName($artistName)
    {
        return
            $this
                ->em
                ->getRepository(Artist::class)
                ->findOneBy([
                    'name' => $artistName
                ]);
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
                    $name = $artist['name'];
                    $artist = new Artist();
                    $artist->setName($name);
                    $this->em->persist($artist);
                }
            }
        }
        $this->em->flush();
    }

    /**
     * @throws GuzzleException
     */
    public function updateArtist($artistName)
    {
        $result = $this
            ->em
            ->getRepository(Artist::class)
            ->findByName($artistName);

        $api = $this->getMusic();
        $name = $api['albums']['tracks']['items']['artists']['name'];

        $result->setName($name);
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

    public function getMusicByTitle($musicTitle)
    {
        return
            $this
                ->em
                ->getRepository(Music::class)
                ->findOneBy([
                    'title' => $musicTitle
                ]);
    }

    public function saveMusic($musicDetails)
    {
        foreach ($musicDetails['albums'] as $album) {
            $items = $album['tracks'];
            $albumObj = $this->getAlbumByTitle($album['name']);
            foreach ($items['items'] as $track) {

                $title = $track['name'];
                $duration = $track['duration_ms'];
                $music = new Music();
                $music->setTitle($title);
                $music->setDuration($duration);
                $music->setAlbum($albumObj);
                $this->em->persist($music);
            }
        }
        $this->em->flush();
    }
}
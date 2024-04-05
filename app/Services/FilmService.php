<?php

namespace App\Services;

use App\Controllers\FormValidators\FilmValidator;
use PDO;
use src\Database\DB;
use src\Route\Route;

class FilmService
{

    public static function getFilmsFromString(string $filmsString): array
    {
        try {
            $readyFilms = [];
            $films = array_filter(preg_split("/(\r?\n){2}/", $filmsString));

            foreach ($films as $movie) {
                $lines = array_filter(preg_split("/(\r?\n)/", $movie));
                $filmAsArray = [];

                foreach ($lines as $line) {
                    list($key, $value) = explode(":", trim($line));
                    $value = trim($value);
                    $snakeKey = preg_replace("/[^a-z_]/", '', strtolower(preg_replace('/\s+/', '_', $key)));
                    $value = $snakeKey === 'release_year' ? (int)$value : $value;
                    $filmAsArray[$snakeKey] = $value;
                }

                $readyFilms[] = $filmAsArray;
            }

            return $readyFilms;
        } catch (\Exception $e) {
            return [];
        }

    }

    public static function deleteInvalidFilms(array $films, int $userId) :array
    {
        $titles = [];
        $validator = new FilmValidator();
        foreach ($films as $key => $film){
            $film['user_id'] = $userId;
            if (!@$validator->createFormValidate($film)  || in_array($film['title'], $titles) ){
                unset($films[$key]);
                $validator->clearErrors();
            } else {
                $titles[] = $film['title'];
            }
        }
        return $films;
    }

    public static function safeOpen(string $name, string $tmpName): ?string
    {
        $pathInfo = pathinfo($name);
        $base = $pathInfo["filename"];
        $base = preg_replace("/[^\w-]/", "_", $base);

        $filename = $base . "." . $pathInfo["extension"];

        $destination = rtrim(ROOT_PATH, '/') ."/tmp/" . $filename;

        if ( !move_uploaded_file($tmpName, $destination)) {
            return null;
        }

        $fileData = file_get_contents($destination);
        unlink($destination);

        if($fileData === FALSE) {
            return null;
        }
        return stripslashes(strip_tags($fileData));
    }
    public static function insertFilm(array $data): bool
    {
        $sql = "INSERT INTO films(user_id ,title, release_year, format, stars)
           VALUES (:user_id ,:title, :release_year, :format, :stars)";
        $pdo = (new DB())->getPdo();
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute(array(
            ":user_id" => $data['user_id'],
            ":title" => $data['title'],
            ":release_year" => (int)$data['release_year'],
            ":format" => $data['format'],
            ":stars" => $data['stars']
        ));
        return $result;
    }

    public static function getUserFilms(int $userId): false|array
    {
        try {
            $db = (new DB())->getPdo();
            $stmt = $db->prepare('SELECT id, title, release_year FROM films WHERE user_id= ? ORDER BY title ');
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (\PDOException $exception){
            Route::redirect('/500');
            return false;
        }
    }

    public static function getFilmById($id): array|false
    {
        try {
            $db = (new DB())->getPdo();
            $stmt = $db->prepare('SELECT * FROM films WHERE id = ?');
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (\PDOException $exception){
            Route::redirect('/500');
            return false;
        }
    }

    public static function destroyFilm(mixed $filmId, ?int $userId): bool
    {
        try {
            $db = (new DB())->getPdo();
            $stmt = $db->prepare( "DELETE FROM films WHERE id =:id AND user_id =:user_id " );
            $stmt->bindParam(':id', $filmId);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            return ($stmt->rowCount());

        } catch (\PDOException $exception){
            Route::redirect('/500');
            return false;
        }

    }

    public static function importFilms(array $films, ?int $userId): int
    {
        if (!$films) {
            return false;
        }

        try {
            $count = 0;
            $db = (new DB())->getPdo();
            $stmt = $db->prepare("INSERT INTO films (user_id, title, release_year, format, stars) 
            VALUES (:user_id, :title, :release_year, :format, :stars)");

            foreach($films as $film) {
                $bind = [];
                $film['user_id'] = $userId;
                foreach ($film as $column => $value) {
                    $bind[$column] = $value;
                }
                $result = $stmt->execute($bind);
                if ($result){
                    $count += 1;
                }
            }
            return $count;
        } catch (\PDOException $e) {
            return 0;
        }

    }

    public static function searchBy(string $searchType, string $value): ?array
    {
        if (! in_array($searchType, [ 'title', 'stars', 'both'])){
            return null;
        }
        try {
            $value = "%$value%";
            $db = (new DB())->getPdo();
            if ($searchType === 'both'){
                $stmt = $db->prepare("SELECT id, title, release_year FROM films WHERE title LIKE :value OR stars LIKE :value");
            } else {
                $stmt = $db->prepare("SELECT id, title, release_year FROM films WHERE $searchType LIKE :value ");
            }

            $stmt->bindParam(':value', $value);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)){
                return null;
            }
            return $result;

        } catch (\PDOException $e) {
            return null;
        }
    }

    public static function getAllTitlesByUserId(int $userId): false|array
    {
        try {
            $db = (new DB())->getPdo();
            $stmt = $db->prepare('SELECT title FROM films WHERE user_id= ?');
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

        } catch (\PDOException $e){
            Route::redirect('/500');
            return false;
        }
    }

}
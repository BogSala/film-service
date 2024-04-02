<?php

namespace App\Services;

use PDO;
use src\Database\DB;
use src\Route\Route;

class FilmService
{
    public static function processImportString($filmsString): array
    {
        try {
            $films = array_filter(explode("\r\n\r\n", $filmsString));
            $readyFilms = [];
            foreach ($films as $movie) {
                $lines = array_filter(explode("\r\n", $movie));
                $filmAsArray = [];

                foreach ($lines as $line) {
                    list($key, $value) = explode(":", trim($line));
                    $value = trim($value);
                    $snakeKey = preg_replace("/[^a-z_]/", '', strtolower(preg_replace('/\s+/', '_', $key)));
                    $filmAsArray[$snakeKey] = $value;
                }

                $readyFilms[] = $filmAsArray;
            }

            foreach ($readyFilms as $key => $film) {
                $starsString = $film["stars"];
                $starsString = str_replace(' ', '', $starsString);
                $starsArray = explode(',', $starsString);
                unset($readyFilms[$key]['stars']);
                $readyFilms[$key]['stars'] = implode(', ' , $starsArray);
            }

            return $readyFilms;
        } catch (\Exception $e) {
            return [];
        }

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

    public static function importFilms(array $films, ?int $userId): bool
    {
        if (!$films){
            return false;
        }

        try {
            $db = (new DB())->getPdo();
            $db->beginTransaction();

            $stmt = $db->prepare("INSERT INTO films (user_id, title, release_year, format, stars) 
            VALUES (:user_id, :title, :release_year, :format, :stars)");

            foreach($films as $film) {
                $bind = [];
                $film['user_id'] = $userId;
                foreach ($film as $column => $value) {
                    $bind[$column] = $value;
                }
                $stmt->execute($bind);
            }
            return $db->commit();
        } catch (\PDOException $e) {
            return false;
        }

    }

    public static function searchBy(string $searchType, string $value): ?array
    {
        if (!($searchType === 'title' || $searchType === 'stars')){
            return null;
        }
        try {
            $value = "%$value%";
            $db = (new DB())->getPdo();
            $stmt = $db->prepare("SELECT id, title, release_year FROM films WHERE $searchType LIKE :value ");

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

}
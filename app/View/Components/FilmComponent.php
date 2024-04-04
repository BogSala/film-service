<?php

namespace App\View\Components;

class FilmComponent extends Component
{
    public static function getFilmsHTML($films): string
    {
        if (!(is_array($films) && isset($films[0]['title']))){
            return '';
        }

        $filmsHTML = [];
        foreach ($films as $film){
            $filmsHTML[] = self::getFilm($film);
        }
        $HTML = '';
        $filmGridData = [];
        foreach ($filmsHTML as $filmHTML)
        {
            $filmGridData[] = $filmHTML;
            if (count($filmGridData) >= 3) {
                $filmGridData = implode("\n", $filmGridData);
                $HTML .= self::getFilmGrid($filmGridData);
                $filmGridData = [];
            }
        }
        if (count($filmGridData) > 0){
            $filmGridData = implode("\n", $filmGridData);
            $HTML .= self::getFilmGrid($filmGridData);
        }
        return $HTML;
    }
    public static function prepareFilmHTML( array $film): string
    {
        return "
        <div class=film>
            <div class=film-title> Title: $film[title]</div>
            <div class=film-release> Release year: $film[release_year]</div>
            <div class=film-format> Format: $film[format]</div>
            <div class=film-stars> Stars: $film[stars]</div>
            <button class=delete id=delete>Delete</button>
            <div id = delete-form-container>
                <form action=/films/destroy method=post class=delete-form id=delete-form>
                <input type=hidden name=film_id value=$film[id]>
                <span>Are you sure?</span>
                <button type=submit class=confirm-deletion id=confirm-deletion>Yes</button>
                </form>
                <button class=cancel-deletion id=cancel-deletion>No</button>
            </div>

        </div>
        ";
    }

    private static function getFilmGrid($filmsHTML): string
    {
        return "
            <div class=grid>
                $filmsHTML
            </div>
        ";
    }
    private static function getFilm($filmData): string
    {
        return "
        <div class=film>
            <div>
                <div class=film-title>
                    $filmData[title]
                </div>
                <small class=film-release>
                    $filmData[release_year]
                </small>
            </div>

            <a class=film-info-button href='/films/$filmData[id]'>
                More
            </a>
        </div>
        ";
    }

    public static function getSearchHTMl()
    {
        if (isset($_SESSION['search_results']) ){
            $results = $_SESSION['search_results'];
        } else {
            $results = null;
        }
        return self::getFilmsHTML($results);
    }

}
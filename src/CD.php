<?php
class CD
{
    private $title;
    private $artist;

    function __construct($title, $artist)
    {
        $this->title = $title;
        $this->artist = $artist;
    }
    function getTitle()
    {
        return $this->title;
    }
    function getArtist()
    {
        return $this->artist;
    }
    function save()
    {
        array_push($_SESSION['cd_list'], $this);
    }

    function matchArtist($artistname, $searchname)
    {
        // $artist = str_split($artistname);
        // $search = str_split($searchname);
        // $searchcount = 0;
        // foreach ($search as $sletter) {
        //     foreach ($artist as $aletter){
        //         if ($sletter == $aletter) {
        //             $searchcount = $searchcount + 1;
        //             if ($searchcount == 3) {
        //                 return true;
        //             }
        //         }
        //     }
        // }
        if (abs(substr_compare($artistname, $searchname, 0, strlen($artistname), TRUE) <= (strlen($artistname)-5)))

        {
            return true;
        };

    }

    static function getAll()
    {
        return $_SESSION['cd_list'];
    }

    static function reset()
    {
        $_SESSION['cd_list'] = array();
    }


}

 ?>

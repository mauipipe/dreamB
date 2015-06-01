<?php
/**
 * Created by David Contavalli <david.contavalli@gmail.com>
 */

namespace API\Utility;


use Cocur\Slugify\Slugify;

class Slugficator {

    public static function createSlug($value){
        $slugify = new Slugify();
        return $slugify->slugify($value);
    }

}
<?php
/**
 * Developer: Page Carbajal (https://github.com/Page-Carbajal)
 * Date: 9/29/15, 6:37 PM
 * Generator: PhpStorm
 */

namespace WPExpress;


use WPExpress\Database\MetaField;
use WPExpress\Database\Post;
use WPExpress\Database\Taxonomy;


class Query
{

    public function __construct()
    {
    }

    /**
     * Returns an new instance to the class Database\Post. Sets the postType property to 'post'. Use method get to return values.
     *
     * @return Database\Post
     */
    public static function Posts()
    {
        $posts = new Post();
        return $posts->postType('post');
    }

    public function Pages()
    {
        $posts = new Post();
        return $posts->postType('page');
    }

    /**
     * Returns an new instance to the class Database\Post. Sets the postType property to 'post'. Use method get to return values.
     *
     * @param $postType . The post type to be queried. 'post', 'page', etc...
     * @return Database\Post
     */
    public static function Custom( $postType )
    {
        $posts = new Post();
        return $posts->postType($postType);
    }

    /**
     * An abbreviation for the Taxonomy method
     * @param $bean
     * @return Database\Taxonomy
     */
    public static function Tax( $bean )
    {
        return self::Taxonomy($bean);
    }

    /**
     * A wrapper for the Taxonomy class constructor
     * @param $bean string, or stdClass object for Taxonomy
     * @return Database\Taxonomy
     */
    public static function Taxonomy( $bean )
    {
        return new Taxonomy($bean);
    }

    public static function Meta( $postID = null )
    {
        return self::MetaFields($postID);
    }

    public static function MetaFields( $postID = null )
    {
        return new MetaField($postID);
    }


    /*******Legacy Method / Will be Droped on 1.0.0*******/
    public static function getMetaValues( $metaKey, $deprecated = 300 )
    {
        return MetaField::getDistinct($metaKey);
    }
}

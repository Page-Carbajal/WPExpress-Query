<?php


namespace WPExpress\Database;


class MetaField
{

    private $postID;

    private static $order;

    private static $limit = 0;

    public function __construct( $postID = null )
    {
        if( !empty( $postID ) ) {
            $this->postID = $postID;
        }
    }

    public function save( $metaKey, $metaValue )
    {

    }

    public function delete( $metaKey )
    {

    }

    private static function boot()
    {
        if( empty( self::$order ) ) {
            self::$order = array();
        }
    }

    private function setOrderField( $fieldName )
    {
        self::boot();
        self::$order['field'] = 'meta_key';
    }

    // Static methods used to Query Fields and Field Values

    public static function orderByID()
    {
        self::setOrderField('meta_key');
    }

    public static function orderByValue()
    {
        self::setOrderField('meta_value');
    }

    private static function setOrderDirection( $asc = true )
    {
        self::boot();
        self::$order['direction'] = ( $asc ? 'ASC' : 'DESC' );
    }

    public static function sortAscending()
    {
        self::setOrderDirection();
    }

    public static function sortDescending()
    {
        self::setOrderDirection(false);
    }

    public static function limit( $max )
    {
        if( intval($max) > 0 ) {
            self::$limit = intval($max);
        }
    }

    public static function getAll( $metaKey, $postIDs = null )
    {
        // By default query all posts, other add where post_id in $postIDs
    }

    public static function getDistinct( $metaKey, $postIDs = null )
    {
        // By default query all posts, other add where post_id in $postIDs

    }

}
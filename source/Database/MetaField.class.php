<?php


namespace WPExpress\Database;


//TODO: Drop this class, move the method getDistinct to Query as a Helper Method


class MetaField
{

    private        $postID;
    private static $order;
    private static $limit               = 0;
    private static $transientExpiration = 300;

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

    public static function setTransientExpiration( $seconds = 300 )
    {
        if( intval($seconds) >= 0 ) {
            self::$transientExpiration = $seconds;
        }
    }

    public static function getAll( $metaKey, $postIDs = null )
    {
        // By default query all posts, other add where post_id in $postIDs
    }

    public static function getDistinct( $metaKey, $postIDs = null )
    {
        // By default query all posts, other add where post_id in $postIDs
        global $wpdb;
        $metaKey     = sanitize_title($metaKey);
        $transientID = "_wpx_metavalues_for_{$metaKey}";

        if( $value = get_transient($transientID) ) {
            return $value;
        } else {
            $items = $wpdb->get_col("SELECT DISTINCT meta_value FROM {$wpdb->postmeta} WHERE (meta_key = '{$metaKey}' AND meta_key IS NOT NULL) ORDER BY meta_value;");
            set_transient($transientID, $items, self::$transientExpiration);
            return $items;
        }

    }

}
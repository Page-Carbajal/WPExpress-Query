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

    protected $parameters;
    protected $metaConditions;
    protected $termConditions;
    protected $metaRelation;
    protected $taxonomyConditions;
    protected $taxonomyRelation;

    public function __construct()
    {
        $this->metaConditions     = array();
        $this->taxonomyConditions = array();
        $this->metaRelation       = $this->taxonomyRelation = 'AND';
        $this->parameters         = array( 'showposts' => 10 );
    }

    private function addParameter( $parameter, $value, $condition = null )
    {
        $this->parameters[$parameter] = $value;
    }

    //
    //    // Set the limit of posts to retrieve;
    //
    //    public function ID( $ID )
    //    {
    //        if( is_array($ID) ) {
    //            $this->addParameter('post_in', $ID);
    //        } else {
    //            $this->addParameter('p', $ID);
    //        }
    //    }
    //
    //    public function status( $status )
    //    {
    //        $this->addParameter('post_status', $status);
    //        return $this;
    //    }
    //
    //    public function all()
    //    {
    //        $this->limit(-1);
    //        return $this;
    //    }
    //
    //    public function limit( $total )
    //    {
    //        if( is_int($total) ) {
    //            $this->parameters['showposts'] = intval($total);
    //        }
    //        return $this;
    //    }
    //
    //    // Post TaxQuery Methods
    //
    //    public function term( $taxonomySlug, $term )
    //    {
    //        $operator = '=';
    //        if( is_array($term) ) {
    //            $operator = 'IN';
    //        }
    //
    //        $this->termConditions[] = array(
    //            'taxonomy' => $taxonomySlug,
    //            'field'    => 'slug',
    //            'terms'    => $term,
    //            'operator' => $operator,
    //        );
    //
    //        return $this;
    //    }
    //
    //
    //    // Post MetaQuery Methods
    //
    //    public function meta( $field, $value, $operator = null )
    //    {
    //        $compare = '=';
    //        if( !empty( $operator ) ) {
    //            $operator = trim(strtolower($operator));
    //        }
    //
    //        if( is_array($value) ) {
    //            $operator = 'in';
    //            $value    = implode(',', $value);
    //        }
    //        switch( $operator ) {
    //            case "like":
    //                $compare = "like";
    //                break;
    //            case "in":
    //                $compare = "in";
    //                break;
    //            case "not":
    //                $compare = "not";
    //                break;
    //            default:
    //                $compare = "=";
    //                break;
    //        }
    //
    //        $this->metaConditions[] = array(
    //            'key'     => $field,
    //            'value'   => $value,
    //            'compare' => $compare,
    //        );
    //
    //        return $this;
    //    }
    //
    //    public function metaRelation( $useAND = true )
    //    {
    //        if( $useAND ) {
    //            $this->metaRelation = 'AND';
    //        } else {
    //            $this->metaRelation = 'OR';
    //        }
    //        return $this;
    //    }
    //
    //
    //    public function postType( $type )
    //    {
    //        $this->addParameter('post_type', $type);
    //        return $this;
    //    }
    //
    //    public function where( $pairs )
    //    {
    //        foreach( $pairs as $field => $value ) {
    //            $this->addParameter($field, $value);
    //        }
    //
    //        return $this;
    //    }
    //
    //    // Process Values
    //    private function buildArguments()
    //    {
    //
    //        if( !empty( $this->metaConditions ) ) {
    //            $this->parameters['meta_query'] = array_merge(array( 'relation' => $this->metaRelation ), $this->metaConditions);
    //        }
    //
    //        if( !empty( $this->termConditions ) ) {
    //            $this->parameters['tax_query'] = $this->termConditions;
    //        }
    //
    //        return $this->parameters;
    //    }
    //
    //    public function get( $return = 'all' )
    //    {
    //        $args  = $this->buildArguments();
    //        $query = new \WP_Query($args);
    //        $posts = $query->get_posts();
    //        wp_reset_postdata();
    //
    //        $bean = $posts;
    //        switch( $return ) {
    //            case 'first':
    //                $bean = reset($bean);
    //                break;
    //            case 'last':
    //                $bean = end($bean);
    //                break;
    //            default:
    //                break;
    //        }
    //
    //        return $bean;
    //    }

    // Static methods

    // Instance methods
    // This methods allow for a simple understanding of the WP_Query Abstraction Layer

    /**
     * Returns an new instance to the class Query. Sets the postType property to 'post'. Use method get to return values.
     *
     * @return Query
     */
    public static function Posts()
    {
        $posts = new Post();
        return $posts->postType('post');
    }

    /**
     * Returns an new instance to the class Query. Sets the postType property to 'post'. Use method get to return values.
     *
     * @param $postType . The post type to be queried. 'post', 'page', etc...
     * @return Query
     */
    public static function Custom( $postType )
    {
        $posts = new Post();
        return $posts->postType($postType);
    }

    /**
     * An abbreviation for the Taxonomy method
     * @param $bean
     * @return Taxonomy
     */
    public static function Tax( $bean )
    {
        return self::Taxonomy($bean);
    }

    /**
     * A wrapper for the Taxonomy class constructor
     * @param $bean string, or stdClass object for Taxonomy
     * @return Taxonomy
     */
    public static function Taxonomy( $bean )
    {
        return new Taxonomy($bean);
    }


    /********* Meta *********/

    public static function MetaFields( $postID = null )
    {
        return new MetaField($postID);
    }


    // Helper methods

    // Legacy function
    public static function getMetaValues( $metaKey, $deprecated = 300 )
    {
        return MetaField::getDistinct($metaKey);
    }


}

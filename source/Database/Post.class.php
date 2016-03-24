<?php


namespace WPExpress\Database;


class Post
{

    private $parameters;
    private $metaConditions;
    private $termConditions;
    private $metaRelation;
    private $taxonomyConditions;
    private $taxonomyRelation;

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


    // Set the limit of posts to retrieve;

    public function ID( $ID )
    {
        if( is_array($ID) ) {
            $this->addParameter('post_in', $ID);
        } else {
            $this->addParameter('p', $ID);
        }
    }

    public function status( $status )
    {
        $this->addParameter('post_status', $status);
        return $this;
    }

    public function all()
    {
        $this->limit(-1);
        return $this;
    }

    public function limit( $total )
    {
        if( is_int($total) ) {
            $this->parameters['showposts'] = intval($total);
        }
        return $this;
    }

    // Post TaxQuery Methods

    public function term( $taxonomySlug, $term )
    {
        $operator = '=';
        if( is_array($term) ) {
            $operator = 'IN';
        }

        $this->termConditions[] = array(
            'taxonomy' => $taxonomySlug,
            'field'    => 'slug',
            'terms'    => $term,
            'operator' => $operator,
        );

        return $this;
    }


    // Post MetaQuery Methods

    public function meta( $field, $value, $operator = null )
    {
        $compare = '=';
        if( !empty( $operator ) ) {
            $operator = trim(strtolower($operator));
        }

        if( is_array($value) ) {
            $operator = 'in';
            $value    = implode(',', $value);
        }
        switch( $operator ) {
            case "like":
                $compare = "like";
                break;
            case "in":
                $compare = "in";
                break;
            case "not":
                $compare = "not";
                break;
            default:
                $compare = "=";
                break;
        }

        $this->metaConditions[] = array(
            'key'     => $field,
            'value'   => $value,
            'compare' => $compare,
        );

        return $this;
    }

    public function metaRelation( $useAND = true )
    {
        if( $useAND ) {
            $this->metaRelation = 'AND';
        } else {
            $this->metaRelation = 'OR';
        }
        return $this;
    }


    public function postType( $type )
    {
        $this->addParameter('post_type', $type);
        return $this;
    }

    public function where( $pairs )
    {
        foreach( $pairs as $field => $value ) {
            $this->addParameter($field, $value);
        }

        return $this;
    }

    // Process Values
    private function buildArguments()
    {

        if( !empty( $this->metaConditions ) ) {
            $this->parameters['meta_query'] = array_merge(array( 'relation' => $this->metaRelation ), $this->metaConditions);
        }

        if( !empty( $this->termConditions ) ) {
            $this->parameters['tax_query'] = $this->termConditions;
        }

        return $this->parameters;
    }

    public function get( $return = 'all' )
    {
        $args  = $this->buildArguments();
        $query = new \WP_Query($args);
        $posts = $query->get_posts();
        wp_reset_postdata();

        $bean = $posts;
        switch( $return ) {
            case 'first':
                $bean = reset($bean);
                break;
            case 'last':
                $bean = end($bean);
                break;
            default:
                break;
        }

        return $bean;
    }

    private function parseOrderField( $field )
    {
        $list    = array( 'none', 'ID', 'author', 'title', 'name', 'type', 'date', 'modified', 'parent', 'rand', 'comment_count', 'menu_order' );
        return ( in_array($field, $list) ? $field : 'date' );
    }

    // Sorting
    public function sortBy( $field )
    {

        $this->addParameter('orderby', $field);
        return $this;
    }

    public function sortOrder( $ascendingOrder = false )
    {
        $this->addParameter('order', ( true == $ascendingOrder ? 'ASC' : 'DESC' ));
        return $this;
    }

}
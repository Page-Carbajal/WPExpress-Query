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
    private $postType;

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
        $allowedOperators = array( '=', '!=', '>', '>=', '<', '<=', 'LIKE', 'NOT LIKE', 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN', 'NOT EXISTS', 'REGEXP', 'NOT REGEXP' );

        $needTypeNumber = array( '>', '>=', '<', '<=' );
        $needArrayValue = array( 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN' );

        $metaCompare = ( in_array($operator, $allowedOperators) ? $operator : '=' );

        // Set $metaCompare = IN if value is an array and $metaCompare is not a $needArrayValue item
        if( !in_array($metaCompare, $needArrayValue) && is_array($value) ) {
            $metaCompare = 'IN';
        }

        // Force value to array if $metaCompare is a $needArrayValue item and $value is not an array
        if( in_array($metaCompare, $needArrayValue) && !is_array($value) ) {
            // Allow for the use of commas to separate values
            if( false !== strpos($value, ',') ) {
                $value = implode(',', $value);
            } else {
                $value = array( $value );
            }
        }

        $conditions = array(
            'key'     => $field,
            'value'   => $value,
            'compare' => $metaCompare,
        );

        if( in_array($metaCompare, $needTypeNumber) ) {
            $conditions['type'] = 'numeric';
        }

        $this->metaConditions[] = $conditions;

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
        $this->postType = $type;
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
        $list = array( 'none', 'ID', 'author', 'title', 'name', 'type', 'date', 'modified', 'parent', 'rand', 'comment_count', 'menu_order' );
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

    // Alias
    public function orderByDate( $newerFirst = true )
    {
        $this->sortBy('date')->sortOrder(!$newerFirst);
        return $this;
    }

    public function orderByEditionDate( $newerFirst = true )
    {
        $this->sortBy('modified')->sortOrder(!$newerFirst);
        return $this;
    }

    public function orderByTitle( $aToZ = true )
    {
        $this->sortBy('title')->sortOrder($aToZ);
        return $this;
    }

    public function orderBySlug( $aToZ = true )
    {
        $this->sortBy('name')->sortOrder($aToZ);
        return $this;
    }

    public function orderByMenuOrder( $lowToHigh = true )
    {
        $this->sortBy('name')->sortOrder($lowToHigh);
        return $this;
    }

    /* Helper Methods */

    public function getMetaFieldValues( $metaKey )
    {
        // By default query all posts, other add where post_id in $postIDs
        global $wpdb;
        $metaKey     = sanitize_title($metaKey);
        $transientID = "_wpx_metavalues_for_{$this->postType}_{$metaKey}";

        if( $value = get_transient($transientID) ) {
            return $value;
        } else {
            $whereClause = "WHERE (meta_key = '{$metaKey}' AND meta_key IS NOT NULL)";
            $whereClause .= " AND AND post_id IN ( SELECT ID FROM {$wpdb->posts} AS posts WHERE posts.post_type = '{$this->postType}' ) ";
            $items = $wpdb->get_col("SELECT DISTINCT meta_value FROM {$wpdb->postmeta} {$whereClause} ORDER BY meta_value;");
            set_transient($transientID, $items, self::$transientExpiration);
            return $items;
        }
    }
}
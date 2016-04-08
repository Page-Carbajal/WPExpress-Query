<?php


namespace WPExpress\Database;


class Taxonomy
{

    protected $tax;
    protected $name;
    protected $capabilities;
    // Search Terms Parameters
    protected $termsLimit;
    protected $termsHideEmpty;
    protected $termsOrder;
    protected $termsOrderBy;
    protected $termName;
    protected $termSlug;


    public function __construct( $bean = null )
    {
        if( is_string($bean) ) {
            $this->tax = get_taxonomy($bean);
        } elseif( is_object($bean) && property_exists($bean, 'name') ) {
            $this->tax = $bean;
        }

        if( isset( $this->tax ) ) {
            $this->name = $this->tax->name;
        }

    }

    /** Search Methods **/

    public function slug( $slug )
    {
        $this->termSlug = $slug;
        return $this;
    }

    public function name( $name )
    {
        $this->termName = $name;
        return $this;
    }

    public function all()
    {
        $this->termsHideEmpty = 0;
        $this->termsLimit     = 0;
        return $this;
    }

    public function limit( $limit )
    {
        $this->termsLimit = intval($limit);
        return $this;
    }

    public function setOrder( $orderBy, $asc = true )
    {
        if( !empty( $orderBy ) ) {
            $this->termsOrderBy = $orderBy;
        }

        $this->termsOrder = ( $asc === true ? 'ASC' : 'DESC' );

        return $this;
    }

    private function getTermsArguments()
    {
        $arguments = array(
            'number' => $this->termsLimit,
        );

        if( isset( $this->termsOrderBy ) ) {
            $arguments['order_by'] = $this->termsOrderBy;
        }

        if( isset( $this->termsOrder ) ) {
            $arguments['order'] = $this->termsOrder;
        }

        if( isset( $this->termName ) ) {
            $arguments['name'] = $this->termName;
        }

        if( isset( $this->termSlug ) ) {
            $arguments['slug'] = $this->termSlug;
        }

        if( isset( $this->termsHideEmpty ) ) {
            $arguments['hide_empty'] = $this->termsHideEmpty;
        }

        // TODO: Complete the arguments list

        return $arguments;
    }

    public function get()
    {
        $terms = get_terms(array( $this->name ), $this->getTermsArguments());
        return $terms;
    }

    /** Traversing Methods **/

    public function getTermBySlug( $slug, $single = true )
    {
        $terms = $this->slug($slug)->limit(1)->setOrder('name', true)->get();
        if( is_array($terms) ) {
            return ( $single ? reset($terms) : $terms );
        }

        return false;
    }

    public function getTermByName( $name, $single = true )
    {
        $terms = $this->name($name)->limit(1)->setOrder('name', true)->get();
        if( is_array($terms) ) {
            return ( $single ? reset($terms) : $terms );
        }

        return false;
    }

    /** Relate to Post Methods **/

    public function appendTo( $bean )
    {
        $this->addTo($bean, true);
    }

    public function replaceIn( $bean )
    {
        $this->addTo($bean, false);
    }

    public function addTo( $bean, $append = true )
    {
        $terms = $this->get();

        if( !is_array($bean) ) {
            $bean = array( $bean );
        }

        foreach( $bean as $postID ) {
            wp_set_object_terms($postID, $terms, $this->name, $append);
        }
    }
    
    public function removeFrom( $bean )
    {
        $terms = $this->get();

        if( !is_array($bean) ) {
            $bean = array( $bean );
        }

        foreach( $bean as $postID ) {
            wp_remove_object_terms($postID, $terms, $this->name);
        }
    }
}
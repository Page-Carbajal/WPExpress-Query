<?php


namespace WPExpress\Database;


class Taxonomy
{

    protected $tax;
    protected $name;
    protected $labels;
    protected $capabilities;
    // Search Terms Parameters
    protected $termsLimit;
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

    protected function setLabels( $name, $pluralName )
    {
        $labels = array(
            'name'                       => $name,
            'singular_name'              => $name,
            'search_items'               => "Search {pluralName}",
            'popular_items'              => "Popular {pluralName}",
            'all_items'                  => "All {pluralName}",
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => "Edit {name}",
            'update_item'                => "Update {name}",
            'add_new_item'               => "Add New {name}",
            'new_item_name'              => "New {name} Name",
            'separate_items_with_commas' => "Separate {pluralName} with commas",
            'add_or_remove_items'        => "Add or remove {pluralName}",
            'choose_from_most_used'      => "Choose from the most used {pluralName}",
            'not_found'                  => "No {pluralName} found.",
            'menu_name'                  => "{pluralName}",
        );

        if( function_exists('apply_filters') ) {
            $labels = apply_filters("wpex_taxonomy_{$name}_labels", $labels);
        }

        $this->labels = $labels;
    }

    protected function getLabels()
    {
        return $this->labels;
    }

    protected function setCapabilities( $capabilities )
    {
        $this->capabilities = $capabilities;
    }

    protected function getCapabilities()
    {
        return $this->capabilities;
    }


    /****CRUD Methods****/

    public static function create( $name, $pluralName, $forObjects = null, $slug = false, $attributes = null )
    {
        $defaultAttributes = array(
            'labels'                => static::getLabels(),
            'rewrite'               => array( 'slug' => ( $slug !== false ? $slug : sanitize_title($name) ) ),
            'description'           => '',
            'public'                => true,
            'hierarchical'          => false,
            'show_ui'               => null,
            'show_in_menu'          => null,
            'show_in_nav_menus'     => null,
            'show_tagcloud'         => null,
            'show_in_quick_edit'    => null,
            'show_admin_column'     => false,
            'meta_box_cb'           => null,
            'capabilities'          => array(),
            'query_var'             => $name,
            'update_count_callback' => '',
            '_builtin'              => false,
        );

        $objects = array();
        if( $forObjects != null ) {
            if( !is_array($forObjects) ) {
                $objects = array( $forObjects );
            } else {
                $objects = array_merge($objects, $forObjects);
            }
        }

        register_taxonomy($name, $objects, array_merge($defaultAttributes, $attributes));

        return new static($name);
    }

    public function edit( $newName, $newSlug = false )
    {

    }

    public function delete()
    {

    }

    /*****Add to Object*****/

    public function classifyObject( $postID )
    {
        // TODO:
    }


    /*****Search Methods*****/

    public function setTermsOrder( $orderBy, $asc = true )
    {
        if( !empty($orderBy) ){
            $this->termsOrderBy = $orderBy;
        }

        $this->termsOrder = ( $asc === true ? 'ASC' : 'DESC' );

        return $this;
    }

    public function setTermsLimit($limit)
    {
        $this->termsLimit = intval($limit);
        return $this;
    }

    private function getTermsArguments()
    {
        $arguments = array(
            'number' => $this->termsLimit,
        );

        if( isset($this->termsOrderBy) ){
            $arguments['order_by'] = $this->termsOrderBy;
        }

        if( isset($this->termsOrder) ){
            $arguments['order'] = $this->termsOrder;
        }

        if( isset($this->termName) ){
            $arguments['name'] = $this->termName;
        }

        if( isset($this->termSlug) ){
            $arguments['slug'] = $this->termSlug;
        }

        // TODO: Complete the arguments list

        return $arguments;
    }

    public function getTerms()
    {
        $terms = get_terms( array( $this->name ), $this->getTermsArguments() );
        return $terms;
    }

    private function setTermSlug( $slug )
    {
        $this->termSlug = $slug;
        return $this;
    }

    public function getTermBySlug( $slug, $asArray = false )
    {
        $terms =  $this->setTermSlug($slug)->setTermsLimit(1)->setTermsOrder('name', true)->getTerms();
        if( is_array($terms) ){
            return ( $asArray ? $terms : reset($terms) );
        }

        return false;
    }

    private function setTermName( $name )
    {
        $this->termName = $name;
        return $this;
    }

    public function getTermByName( $name, $asArray = false )
    {
        $terms =  $this->setTermName($name)->setTermsLimit(1)->setTermsOrder('name', true)->getTerms();
        if( is_array($terms) ){
            return ( $asArray ? $terms : reset($terms) );
        }

        return false;
    }
}
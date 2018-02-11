# WPExpress/Query

An abstraction layer for WPDB.

Love **WordPress** I started looking for a composer package to abstract working with the **WPDB** the way we work with databases on other PHP projects. 

None met my expectations, some try to skip the **WBDP** and write SQL on their own. WPDB is robust enough, I just want a wrapper that makes read and writing code easier.
 

The **Query** class is a container for static methods to instantiate every class (**Post**, **MetaField**, **Taxonomy**) related to the DB. 


You can use **WPExpress/Query** to simplify your interactions with the WPDB and make your code easier to read and write.

**Run a DB Query for Custom Post Type BOOKS, and limit to 5 results**

```php
function getFiveBooksPermalinks()
{
    $list = array();
    $fiveBooks = Query::Custom('book')->limit(5)->get();

    foreach($fiveBooks as $post)
    {
        $list[] = get_permalink($post->ID);
    }
    return $list;
}
```


**Run a DB Query to get 5 posts**

```php
    $Posts = Posts()->limit(5)->get();

    foreach($Posts as $post)
    {
        // TODO: Write your code here
    }
```


## Road Map

### Next minor 
- Add methods insert, save and delete to Post class
- Develop methods for User class
    - insert
    - save
    - delete
    - resetPassword
    - get, get first, get last
    - getAll
    - getByMeta
    - getByEmail
- Add method Query::User. Returns an instance of User




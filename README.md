# WPExpress/Query

An abstraction layer for WPDB.

Love **WordPress** I started looking for a composer package to abstract working with the **WPDB** the way we work with databases on other PHP projects. 

None met my expectations, some try to skip the **WBDP** and write SQL on their own. WPDB is robust enough, I just want a wrapper that makes read and writing code easier.
 


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




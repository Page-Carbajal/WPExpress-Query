#WPExpress/Query

An abstraction layer for WPDB.
 
##Change Log


###TODO

- Version 0.13.0
    - Add method Query::UserRole. Returns an instance of UserRole
    - Develop methods for UserRole class
        - insert
        - save
        - delete
        - get
        - getAll
        - getUsers
        - addMember
        - removeMember
- Version 0.12.0 
    - Refactor Taxonomy class
    - Add methods insert, save and delete to Taxonomy class
    - Add methods insert, save and delete to Post class
    - Develop methods for User class
        - insert
        - save
        - delete
        - resetPassword
        - get, get first, get last
        - getCurrent
        - getAll
        - getByMeta
        - getByEmail
        - getMetaFields
        - getRoles
        - addRole
        - removeRole
        - makeAdmin
        - getSites
    - Add method Query::User. Returns an instance of User


###Version 1.0.0 - Post class, Additional Taxonomy methods and streamlining of the Query class

- Deleted Database/MetaField class from Repository
- Deprecated method Query::getMetaFieldValues
- Ported method MetaField/getDistinct to Post/getMetaFieldValues
- Deprecated methods Query/MetaField and Query/Meta
- Added sorting Alias methods 
- Finished methods Post/sortBy and Post/sortOrder
- Created method Pages. Works just like custom but it sets the type to Page
- Create method Tax it returns an instance of Database/Taxonomy 
- Created method Posts it returns an instance of Database/Post
- Moved all Post methods from Query to new Post class
- Added method Query::Meta
- Deleted all commented code on Query class
- Prepared function Query::getMetaValues for deprecation
- Moved all the Post code to the Post class
- Finished basic implementation of MetaField::getDistinct 
- Added MetaFields method to Query
- Created all empty methods for the MetaField class  
- Added empty Database/MetaField
- Added empty Database/Post
- Added wrapper methods Tax and Taxonomy to Query


###Version 0.10.4

- Fixed the query term method error 

###Version 0.10.3

- Implemented Taxonomy/all method
- Implemented the sue of safeName on Taxonomy registration
- Fixed Taxonomy query_vars declaration
- Fixed label declarations


###Version 0.10.2

- Fixed array_merge error


###Version 0.10.1

- Changed the Taxonomy registration


###Version 0.10.0

- Added empty User, UserRole and Transient classes 
- Added Taxonomy class


###Version 0.9.0

- Enhanced the get method
- Implemented function where
- Implemented function status to set the post status
- Code refactoring

###Version 0.8.0 

- Creating a independent repository for this project

###Previous Versions

- All previous versions where developed within the WPExpress Framework(https://github.com/Page-Carbajal/WPExpress)

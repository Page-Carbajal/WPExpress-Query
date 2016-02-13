#WPExpress/Query

An abstraction layer for WPDB.
 
##Change Log


###TODO

- Tag to version 0.13.0
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
- Tag to version 0.12.0 
- Add method Query::User. Returns an instance of User
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
- Tag to version 0.11.0
- Add methods insert, save and delete to Taxonomy class
- Add methods insert, save and delete to Post class
- Create method Tax it returns an instance of Database/Taxonomy. Create instance if none exists 
- Deprecate method Posts
- Create method Post it returns an instance of Database/Post. Create instance if none exists
- Move all Post methods from Query to new Post class
- Add Database/Post class

###Version 0.11.0 - Post class, Additional Taxonomy methods and streamlining of the Query class

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

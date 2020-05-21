# WP Express Query - Change Log

## Version 1.0.2 - May 21st

- Refactored class names for PRS-4 compliance


## Version 1.0.1 

- Fixed issued: License "GPL3" is not a valid SPDX license identifier


## Version 1.0.0 - Post class, Additional Taxonomy methods and streamlining of the Query class

- Removed WPExpress/Model related methods 
- Dropped CRUD methods from Taxonomy class
- Added relational methods to Taxonomy class
- Finished Taxonomy class refactoring
- Added methods Post/onlyID and Post/parentIDs. Closes #3
- Added method Post/getSQLRequest. Closes #2
- Extended the number of operators allowed for meta_query. Closes #1
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


## Version 0.10.4

- Fixed the query term method error 


## Version 0.10.3

- Implemented Taxonomy/all method
- Implemented the sue of safeName on Taxonomy registration
- Fixed Taxonomy query_vars declaration
- Fixed label declarations


## Version 0.10.2

- Fixed array_merge error


## Version 0.10.1

- Changed the Taxonomy registration


## Version 0.10.0

- Added empty User, UserRole and Transient classes 
- Added Taxonomy class


## Version 0.9.0

- Enhanced the get method
- Implemented function where
- Implemented function status to set the post status
- Code refactoring


## Version 0.8.0 

- Creating a independent repository for this project


## Previous Versions

- All previous versions where developed within the WPExpress Framework(https://github.com/Page-Carbajal/WPExpress)
# mainlandhouses
the code is a real estate app, it allows for the
## Setup

create "config" folder in the root of the project and create "database.php" in to it

and fill it with the following content

```
$config['database']['driver'] ="mysql"; //mysql || sqllite
$config['database']['name'] =""; //name of the db you are trying to connect to
$config['database']['user'] =""; //db username
$config['database']['password'] =""; //db user password
$config['housePictureDir']['unCategorisedPictures']="/assets/images/houses" //house images folder    
 ```
 
 create mysql db and import the "dbStructureBackup.sql" in the root of the project to populate the db with the database structure
 
 # instruction to setup admin functionality will be provided later.

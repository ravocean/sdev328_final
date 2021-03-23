# sdev328_final
Final project for SDEV 328 with Ryan
- [x]Separates all database/business logic using the MVC pattern.
- All business logic related files are contained in the Model folder files: data-layer.php, adminDash.php, and validate.php.

- [x]Routes all URLs and leverages a templating language using the Fat-Free framework.
- All ULR's and routes utilize the Fat-Free framework routes and render functions in index.php and controller.php.

- [x]Has a clearly defined database layer using PDO and prepared statements. You should have at least two related tables.
- All database queries are passed through PDO bindParam functions in the Model layer in data-layer.php and adminDash.php.

- [x]Data can be viewed and added.
- Individual User vehicles can be added and viewed from the userDash page.
- Individual User vehicles can be viewed and their status's updated from the adminDash page.
- All User vehicles can be viewed from the adminDash page.
- User/Admin accounts can be added from the newAccount page.

- [x]Has a history of commits from both team members to a Git repository. Commits are clearly commented.
- There are 50+ commits all with descriptive comments.  A couple slipped-by by accident without a complete comment.

- [x]Uses OOP, and defines multiple classes, including at least one inheritance relationship.
- Vehicle, Account, and Customer class objects are used.  The Customer object inherits from the Account object.

- [x]Contains full Docblocks for all PHP files and follows PEAR standards.
- All functions and classes use docblocks and PEAR standards were followed.

- [x]Has full validation on the client side through JavaScript and server side through PHP.
- All validation is accomplished server side through validate.php.

- [x]All code is clean, clear, and well-commented. DRY (Don't Repeat Yourself) is practiced.
- The only violation of this standard was in adminDash.js where i had an issue using jQuery selectors for objects that were appended after the page was loaded, so there is a couple lines of repeated code for .edit and .save.

- [x]Your submission shows adequate effort for a final project in a full-stack web development course.
- We managed 50+ commits and probably over 100 hours of work between the two of us.
- Our project utilizes HTML/CSS/JS/jQuery/Fat-Free/PDO/MySQL/PHP/AJAX.

- [x]GitHub repo includes readme file outlining how each requirement was met; UML diagram; and ER diagram
- UML and ER diagrams added to directory.

- [x]Presentation is under 5 minutes, and is well-prepared and delivered.
- Completed in class.

- [x]BONUS  Incorporates Ajax that access data from a JSON file, PHP script, or API. If you implement Ajax, be sure to describe it in your readme file.
- Implemented ajax commands in adminDash.js that access data using adminDash.php
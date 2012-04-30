DROP TABLE IF EXISTS fl_decks;
DROP TABLE IF EXISTS fl_cards;
DROP TABLE IF EXISTS fl_students;

CREATE TABLE fl_cards (
   card_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
   deck_id INT(10) NOT NULL,  
   position INT(4) NOT NULL,
   question VARCHAR(160) NOT NULL,
   answer VARCHAR(160) NOT NULL,
   PRIMARY KEY(card_id)) ENGINE=InnoDB CHARSET=UTF8;
   
CREATE TABLE fl_decks (
   deck_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,   
   deck_name VARCHAR(160) NOT NULL,
   PRIMARY KEY(deck_id)) ENGINE=InnoDB CHARSET=UTF8;
   
CREATE TABLE fl_students (
   row_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,  
   student_id INT(10) NOT NULL,  
   deck_id INT(10) NOT NULL,  
   position INT(4) NOT NULL,
   answer BOOLEAN,
   PRIMARY KEY(row_id)) ENGINE=InnoDB CHARSET=UTF8;
   

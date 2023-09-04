
CREATE TABLE `review_table` (
  `review_id` int(11) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `user_rating` int(1) NOT NULL,
  `user_review` text NOT NULL,
  `datetime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `review_table`
  ADD PRIMARY KEY (`review_id`);


ALTER TABLE `review_table`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;




ALTER TABLE Statement (Primary Key) :
Cela ajoute une contrainte de clé primaire à la table review_table en utilisant la colonne review_id. Une clé primaire garantit que chaque valeur dans la colonne review_id est unique et qu'elle identifie de manière unique chaque enregistrement dans la table.

ALTER TABLE Statement (MODIFY) :
Cela modifie la structure de la table. La colonne review_id est modifiée pour être une colonne auto-incrémentée. Cela signifie que chaque fois qu'un nouvel enregistrement est inséré dans la table, la valeur de review_id sera automatiquement incrémentée, évitant ainsi les conflits d'identifiants et garantissant une valeur unique pour chaque avis. AUTO_INCREMENT=9 définit la valeur de départ pour la colonne auto-incrémentée (elle commence à partir de 9). -->
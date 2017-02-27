TSchan

Le dossier Temp va servir à recueuillir les images uploadé via le drag'n'drop
La table temp, pour chopper un id, et noter le chemin :
	En soi, elle ne servira qu'à renvoyer l'image temporaire dans la requete sql qui va vers le fichier permanent

Toutes les pages utilisent du php, sauf script.js, et TSchan.css
Les pages full js et full php sont hyper commentées mais au cas où...
	La page JS est organisée :

l.1 		1-Déclaration des variables
l.32		2-Fonction Resize images
l.64		3-Fonction Upload images 
				=> celle qui pose problème
l.89		4-Fonction Afficher images
l.139		5-Fonction Récupérer les images de l'input file
				=>envoie son résultat à Afficher image
l.169		6-Fonction récupérer l'image du drag'n'drop
				=> qui fait des actions à chaque étape du drag
				=> au drop, récupère l'image et l'envoie à Afficher Image

L'idée du truc, c'est que comme je ne peux pas entrer dans l'input file et mettre l'image droppée dedans, je bypass tout ça.
Je pense mettre un event 'click' sur le bouton submit pour prendre l'image affichée en bas du formulaire et l'envoyer dans la fonction d'upload et la stocker dans un dossier temporaire.

Ensuite en php, je récupère l'image stockée en temporaire, j'efface le contenu du dossier temporaire, je rentre l'image dans le dossier permanent.


Bref, concernant le script, je récupère l'image via un this (input) ou un e.dataTransfer (dragndrop), et j'ai une variable en fin de fonction qui est la même que si elle était passée par l'autre méthode.
J'essaye de l'envoyer via un XLMHttprequest.
Je la prépare à m'envoyer une donnée en POST sur add.php
Je crée un 'new FormData();' (l.81)
je fais un FormData().append('index', value);

	=>Le problème arrive là. Je console.log() mon FormData(), il est vide.

	J'ai essayé : 
		d'envoyer 	file (argument de la fonction d'affichage), (l. 92)
					this (l.142)
					files (là où je stocke l'image), (l. 143, l. 198)
					files['0'] (la partie qui contient l'image dans l'objet files).
		de changer le nom de ma variable formData (au cas où c'est un nom réservé).

La page add.php renvoie juste un var_dump($_FILES) ou var_dump($_POST) puisque j'aimerais vérifier ce que je reçois avant de coder ce qui va traiter la réponse.

Bref je ne comprends pas bien ce qu'il se passe ou pourquoi ça ne marche pas, sachant que l'image qui s'affiche est la 'preuve' que l'image va jusqu'au bout de la fonction. Au pire, la fonction taylorSwift(); est là pour checker jusqu'où le script va.
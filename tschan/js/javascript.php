<script type="text/javascript">
/* ---------- VARIABLES ------------- */

//taylorSwift(); pour voir où un script s'arrête
function taylorSwift(){ 
	console.log('Taylor Swift <3');
}

//Objet contenant les variables qui ont les valeurs getElements et querySelector
var selectors = new Object(),
/* Drag'n'Drop */
//On sélectionne l'élément où on veut dropper des fichiers
//Le formulaire (<form>) entier qui gère les infos
	dropper = document.querySelector('#dropper'),
//Le titre pour le changement de couleur
	formTitle = document.querySelector('#formTitle'),
/* Sécurité */
	textArea = dropper.querySelector('textarea'),
	title = dropper.querySelector('.checkClass'),
/* Récupérer img de l'input file */
	inputFile = dropper.querySelector('#file'),
	hidden = dropper.querySelector('#droppedFile'),
/* Changement taille image */
	pictures = document.querySelectorAll('.resize'),
/* Preview */
//Définition de host(=>div où il y aura l'image affichée), button(=>submit)
	host = dropper.querySelector('#host'),
	button = dropper.querySelector('#button');
//Définition des format acceptés
var allowedTypes = ['png', 'gif', 'jpg', 'jpeg', 'bmp', 'tiff'];
//Formulaire js
var form_data = new FormData();





/* ------------ MODIFIER TAILLE IMAGE -------------- */

//Fonction pour changer la taille de l'image
function changeSize(){
//on compte le nombre d'images sur la page
	var picturesLength = pictures.length;
//on boucle à partir de 0 jusqu'à la longueur du tableau		
	for (var i = 0; i < picturesLength; i++) {
//à chaque tour, el prend la valeur de l'index [nombre de boucle]
		var picture = pictures[i];
//on y ajoute un eventListener au click
		picture.addEventListener('click', function(){
//On change la classe de l'élément cliqué (this)
//medium et tiny => vers big + un marqueur pour connaitre la taille originelle
//big => vers taille originelle
    		if (this.className == "resize medium"){
				this.className = "resize big fromMed";
    		} else if (this.className == "resize tiny"){
    			this.className = "resize big fromTiny";
    		} else if (this.className == "resize big fromMed") {
    			this.className = "resize medium";
    		} else if (this.className == "resize big fromTiny"){
    			this.className = "resize tiny";
    		}
   		});
	}
}
//Si on n'appelle pas la fonction, elle ne marchera jamais...
changeSize();






/* --------------- Upload des images --------------- */

function uploadForm(){
//On crée une requête XMLHttp		
	var request = new XMLHttpRequest();
//Qui enverra des données en POST, vers add.php?...
	request.open('POST', 'add.php?<?=$id?>=<?=$_GET['id']?>&where=<?=$whatForm?>');
//On récupère toutes les données entrées dans le formulaire
	var bind_form = dropper.querySelectorAll('.formContent');
//On bind les données récupérées dans le FormData
	for (var i = 0; i < bind_form.length; i++) {
		form_data.append(bind_form[i].name, bind_form[i].value);
	}
//On envoie le formulaire
	request.addEventListener('load', function(){
		document.location.href="<?=$whatForm?>.php?id=<?=$_GET['id']?>";
	});
	request.send(form_data);
/* 
//Afficher le contenu d'un FormData :
//console.log(form_data.get('pic'));
*/
}




/* ------------- Afficher une image en preview -------------- */

//Fonction qui crée un aperçu sous le sélecteur de fichier
function showPic(file) {
//On pète le required de l'input file
	inputFile.removeAttribute('required');
//preset pour que JS lise l'image 
	var reader = new FileReader();
//Dès que l'image est complètement chargée
//Il lance la fonction bind
	reader.addEventListener('load', function bind() {
//création d'une variable 'isset' qui a pour utilité de créer un test similaire à isset()(php)
		var isset = document.getElementById('preview');
//Si l'endroit où on va mettre l'image est vide quand on en met une 
		if (isset==null) {
//On crée une balise img
			var imgElement = document.createElement('img');
//on lui set une max-width, max-heigth, display, un id
			imgElement.style.display = 'block';
			imgElement.style.maxWidth = '142px';
			imgElement.style.maxHeight = '142px';
			imgElement.style.margin= '0 auto';
			imgElement.id = 'preview';
//On récupère la source
			imgElement.src = this.result;
//On met la balise image dans la balise qui a l'ID host
			host.appendChild(imgElement);
//On set les valeur de la div host
			host.setAttribute('style', 'overflow: hidden; width: 100%; margin-bottom: 20px;');
			var img = document.getElementById('preview');
//Sinon (si il y a une image)
		} else {
			var img = document.getElementById('preview');
//On réattribue la source de l'image
			img.setAttribute("src", this.result);
		}
	}, false);
//Permet de lire le fichier envoyé
	reader.readAsDataURL(file);
//On set le formulaire js avec l'image
//S'il y en a une avant, elle est écrasée par la nouvelle
	form_data.set('pic', file);
}





/* ------------ Gestion submit ------------- */
	
//Au clic du submit, on envoie lance submit
button.addEventListener('click', function(event) {
//On récupère les required dans un tableau
//On ne déclare pas required au top parce que l'input file perd required quand une image est affichée
	var required = dropper.querySelectorAll('[required]');
//On l'envoie dans une fonction. Si elle renvoie true on upload
	if(checkData(required)) {
		uploadForm();
		event.preventDefault();
	} else {
		alert('Fill the form');
	}
});





/* ----------------- Check Required ----------------- */

function checkData(array){
//On récupère la longueur du tableau
	var len = array.length;
//On boucle sur tout le tableau
	for (var i = 0; i < len; i++) {
//Si il n'y a pas de valeur la fonction retourne false
		if (!array[i].value){
			return false;
		}
	}
//Si la fonction finit la boucle, elle retourne vrai
	return true;
}




/* ----------------- Récupérer l'image de l'input file ----------------- */
	
//Quand il y a un changement sur l'input file
inputFile.addEventListener('change', function() {
	var files = this.files,           
	    imgType;
//On crée un tableau dans lequel on prend le nom du fichier,
//On crée un nouvel index à chaque '.'
//image.jpg => array('image', 'jpg')
	imgType = files['0'].name.split('.');
//On garde la deuxième valeur, çad l'extension
	imgType = imgType[imgType.length - 1];
//Si l'extension stockée dans imgType existe dans le tableau des types acceptés
//Càd, si le fichier est une image ok pour la db, on affiche
	if(allowedTypes.indexOf(imgType) != -1) {
//On affiche l'image
		showPic(files['0']);
	} else {
//Si le fichier n'est pas une image acceptée dans la db, on pète l'image et on replace le button
		var img = document.getElementById('preview');
		img.removeAttribute('src');
	}
}, false);





/* ------------- DRAG N DROP ------------ */

//On lui autorise à recevoir les drops
//On set les paramètres quand on est en hover
dropper.addEventListener('dragover', function(e) {
// Annule l'interdiction de drop
	e.preventDefault();
//Change la couleur de fond du formulaire
	dropper.setAttribute('style', 'background-color: #ff6bac;');
//le h3 est au dessus du formulaire, il est aussi affecte par le changement de couleur
	formTitle.setAttribute('style', 'background-color: #ff6bac;');
	}, false);
//Change la couleur du fond dès qu'on arrive au dessus du formulaire
dropper.addEventListener('dragenter', function(){
	dropper.setAttribute('style', 'background-color: #ff6bac;');
	formTitle.setAttribute('style', 'background-color: #ff6bac;');
});
//Remettre les couleurs quand on sort du drag
dropper.addEventListener('dragleave', function(){
	dropper.setAttribute('style', 'background-color: #ffadd1;');
	formTitle.setAttribute('style', 'background-color: #ffadd1;');
}, false);
//Remettre les couleurs quand on drop le fichier
dropper.addEventListener('drop', function(e){
	dropper.setAttribute('style', 'background-color: #ffadd1;');
	formTitle.setAttribute('style', 'background-color: #ffadd1;');
//On empêche les erreurs dues au drag'n'drop non accepté par les navigateurs
	e.stopPropagation();
	e.preventDefault();
//On récupère le fichier laché au drop
       var files = e.dataTransfer.files,
	    imgType;
//On crée un tableau dans lequel on prend le nom du fichier,
//On crée un nouvel index à chaque '.'
//image.jpg => array('image', 'jpg');
	imgType = files['0'].name.split('.');
//On garde la dernière valeur, çad l'extension
	imgType = imgType[imgType.length - 1];
//Si l'extension stockée dans imgType existe dans le tableau des types acceptés
//Càd, si le fichier est une image ok pour la db, on l'envoie dans la fonction afficher
	if(allowedTypes.indexOf(imgType) != -1) {
// On envoie l'image dans la fonction qui l'affiche
	showPic(files['0']);
	}
}, false);
</script>
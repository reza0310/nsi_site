for (i = 1; i <= document.getElementsByName("nbre").item(0).value; i++) {
	let val = i.toString()
	let div = document.getElementById("p"+val);
	let inp = document.getElementsByName("n"+val).item(0);
	if (div != null) {
		div.addEventListener('click', event => {   // Si la div du ième produit est cliquée, on augmente le nombre de ce produit dans la commande stocké 
			if (inp.value < parseInt(inp.max)) {
				inp.value = parseInt(inp.value)+1;   // sous forme d'input de type hidden de 1 puis on actualise l'affichage.
				majvaleurs();
			};
		});
		div.addEventListener('contextmenu', event => {			// Si la div du ième produit est clique-droitée, on réduit le nombre de ce produit dans la commande stockée 
			event.preventDefault()
			if (inp.value > 0) {
				inp.value = parseInt(inp.value)-1;   // sous forme d'input de type hidden de 1 puis on actualise l'affichage.
				majvaleurs();
			};
		});
		div.addEventListener('mouseenter', event => {   // Si la div du ième produit est clique-droitée, on réduit le nombre de ce produit dans la commande stockée 
			document.getElementById("d"+val).style.background = "#de6e12";
			document.getElementById("d"+val).style.borderTop = "2vh solid #de6e12";
			//var styleElem = document.head.appendChild(document.createElement("style"));
			//styleElem.innerHTML = ".description-article::after {border-top: 20px solid #de6e12;}";
			document.getElementById("d"+val).style.color = "#ffffff";
		});
		div.addEventListener('mouseleave', event => {   // Si la div du ième produit est clique-droitée, on réduit le nombre de ce produit dans la commande stockée 
			document.getElementById("d"+val).style.background = "transparent";
			document.getElementById("d"+val).style.borderTop = "2vh solid transparent";
			document.getElementById("d"+val).style.color = "transparent";
			//var styleElem = document.head.appendChild(document.createElement("style"));
			//styleElem.innerHTML = ".description-article::after {border-top: 20px solid transparent;}";
		});
	};
};


for (i = 1; i <= document.getElementsByName("fam").item(0).value; i++) {
	let div = document.getElementById("f"+i.toString());
	let closee = document.getElementById("close_"+i.toString());
	console.log(closee.outerHTML)
	div.addEventListener('click', event => {
		var children = div.children;
		for (i = 0; i < 2; i++) {
		  children[i].style.display = "none";
		};
		for (i = 2; i < children.length; i++) {
		  children[i].style.display = "inherit";
		};
		closee.style.display = 'inherit';
	});
	closee.addEventListener("click", event => {
	var children = div.children;
	for (i = 0; i < 2; i++) {
		children[i].style.display = "inherit";
	};
	for (i = 2; i < children.length; i++) {
		children[i].style.display = "none";
	};
	closee.style.display = 'none';
	});
};

document.getElementById("reinit").addEventListener('click', event => {   // Programmation du bouton réinitialiser de sorte à ce qu'il ne nécessite ni form ni input ni connection ni ...
  for (i = 1; i <= document.getElementsByName("nbre").item(0).value; i++) {
	var div = document.getElementsByName("n"+i.toString()).item(0);
	if (div) {
		div.value = 0;
	};
  };
  majvaleurs();
});

function majvaleurs() {
	let srt = "";   // On créé le str résultat
	for (i = 1; i <= document.getElementsByName("nbre").item(0).value; i++) {
		var n = document.getElementsByName("n"+i.toString()).item(0);  // On récupère le nombre de produits
		if (!n) {
			var n = 0;
		} else {
			var n = n.value;
		};
		if (n != 0) {
			srt += "-"+document.getElementById("p"+i.toString()).firstChild.alt+": " + n.toString() + "<br>";   // On concatene l'affichage du produit
		};
	};
	document.getElementById("glouton").innerHTML = srt;   // On place le str dans la page web
};

//document.addEventListener('contextmenu', event => event.preventDefault());
document.styleSheets[0].insertRule(":root{overflow-y:hidden;}");
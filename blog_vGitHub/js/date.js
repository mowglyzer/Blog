var dateGlobale = new Date();

var annee = dateGlobale.getFullYear();
var mois = dateGlobale.getMonth();
var jour = dateGlobale.getDate();
var jour_semaine = dateGlobale.getDay();

var heure = dateGlobale.getHours();
var minute = dateGlobale.getMinutes();
var seconde = dateGlobale.getSeconds();

if (heure < 10) { heure = "0" + heure; }
if (minute < 10) { minute = "0" + minute; }
if (seconde < 10) { seconde = "0" + seconde; }

var MOIS = ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "aout", "septembre", "octobre", "novembre", "décembre"];
var JOUR_SEMAINE = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];

mois = MOIS[mois];
jour_semaine = JOUR_SEMAINE[jour_semaine];

document.getElementById("date").innerHTML = jour_semaine + " " + jour + " " + mois + " " + annee + " - " + heure + " : " + minute + " : " + seconde;
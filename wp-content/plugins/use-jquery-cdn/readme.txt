=== Use jQuery CDN ===
Contributors: luciole135
plugin url: http://additifstabac.free.fr/index.php/use-jquery-cdn/
Tags: CDN, MAXCDN, jquery, js, jquery-migrate, optimisation, speed, WordPress Performance
Donate link: additifstabac@free.fr
Requires at least: 2.8
Tested up to: 4.2
Stable tag: 1.1

Charge les bibliothèques open source jQuery et jQuery-migrate depuis le CDN de jQuery délivré par MAXCDN

== Description ==
= French =
* Un plugin extremement léger pour charger les scripts jquery et jquery migrate de wordPress depuis les CDN de la fondation jQuery dont WordPress est membre fondateur. 
* Il est délivré par MAXCDN qui est un membre de platine de cette même fondation. Il permet d'optimiser et d'accélerer WordPress.
* Il augmente d'environ 5% le Page Speed Grade de GTmetrix.
* Il accélère le chargement d'au moins 1 seconde.
* Il est écrit en 10 lignes de code et pèse environ 0,005 Mo.
* Il détecte automatiquement la version du script utilisée par votre thème et effectue une requête vers cette dernière sur le CDN de CDN.

* Plus d\'information ici : http://additifstabac.free.fr/index.php/use-jquery-CDN/

= English =
* An extremely light plugin to load jquery and jquery migrate scripts from the CDN of the jQuery foundation that WordPress is a founding member.
* It is issued by MAXCDN which is a platinum member of that foundation.It increases approximately 5% Page Speed ​​Grade on GTmetrix.
* It accelerates the loading of at least 1 second.
* It is written in 10 lines of code and weighs about 0.005 MB
* It automatically detects the version of the script used by your theme and makes a request to it on MAXCDN.

* More info (in french): http://additifstabac.free.fr/index.php/use-jquery-CDN/

== Installation ==
1. Dézippez l\'archive et placez là dans le dossier /wp-content/plugins
1. Activez le \'Plugin\' depuis le tableau de bord de WordPress
1. Il fonctionne dès l\'activation en arrière plan et ne nécessite aucun réglage.

== Changelog ==
= 1.0.1 =
* Do not show the version of jQuery, masonry and jquery-migrate as recommended by gtmetrix
"Most proxies, most notably Squid up through version 3.0, do not cache resources with a "?" in their URL even if a Cache-control: public header is present in the response. To enable proxy caching for these resources, remove query strings from references to static resources, and instead encode the parameters into the file names themselves."
http://gtmetrix.com/remove-query-strings-from-static-resources.html
= 1.0.2 =
* French : Affectation d'une priorité basse d'exécution du plugin afin de permettre à ce plugin d'agir en tout dernier lieu après les autres plugins.  Ceci permet d'assurer la compatibilité avec les autres plugins agissant eux aussi sur les scripts jQuery.
* English: Assigning a low priority for the implementation of the plugin to allow this plugin to act as a last place after the other plugins. This ensures compatibility with other plugins modifying the jQuery scripts.
= 1.1 =
* French : Utilisation du protocole https en lieu et place de http.
* English: Using https instead of http protocol.
# Elite-US Public Portal v3

Version publique du portail Elite-US, pensée comme point d’entrée commercial vers les produits et services de l’entreprise.

## Principes de la V3

- le site public reste orienté client et **n’expose pas l’architecture interne** de l’écosystème ;
- les produits et services publics sont centralisés dans `assets/data/catalog.fr.json` ;
- le visiteur peut décrire son besoin et recevoir une orientation vers un produit ou service pertinent ;
- les solutions peuvent proposer accès web, démonstration, téléchargement ou commande ;
- KoloService est mis en avant comme marketplace de services ;
- le parcours de commande/devis est découpé en trois étapes courtes ;
- chaque demande continue d’être traitée par `api/request.php` et reçoit une référence `EU-YYYYMMDD-XXXXXX`.

## Fichiers principaux

- `index.html` — portail public V3 ;
- `assets/css/styles.css` — styles responsive ;
- `assets/js/app.js` — catalogue, filtres, orientation et tunnel de commande ;
- `assets/data/catalog.fr.json` — catalogue public des produits/services ;
- `api/request.php` — réception et journalisation des demandes ;
- `privacy.html` — confidentialité ;
- `robots.txt` / `sitemap.xml` — SEO technique.

## Catalogue public

Chaque produit peut définir :

- nom et identifiant ;
- catégorie ;
- statut public ;
- plateformes ;
- mots-clés d’orientation ;
- URL du site produit ;
- URL de démonstration ;
- téléchargements disponibles.

À terme, ce fichier statique pourra être remplacé par l’API du catalogue central sans changer la logique générale du portail.

## Déploiement

Déployer sur Apache/PHP. Vérifier que PHP peut écrire dans `storage/requests/` et configurer un transport e-mail de production. Les demandes clients ne doivent jamais être publiées dans Git.

## À compléter progressivement

- vrais logos produits ;
- captures d’écran et vidéos ;
- sites spécialisés de chaque produit ;
- liens de démonstration et téléchargements manquants ;
- comptes clients et suivi des commandes lorsqu’ils seront disponibles côté backend ;
- version anglaise complète.

## Sécurité

Le dossier `storage/` reste protégé par `.htaccess`. Les secrets, clés API et données clients ne doivent jamais être placés dans le dépôt public.

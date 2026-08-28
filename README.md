# Elite-US Public Portal v3.1

Version publique du portail Elite-US, pensée comme point d’entrée commercial vers les produits et services de l’entreprise.

## Principes

- le site public reste orienté client et **n’expose pas l’architecture interne** de l’écosystème ;
- les produits et services publics sont centralisés dans `assets/data/catalog.fr.json` ;
- le visiteur peut décrire son besoin et recevoir une orientation vers un produit ou service pertinent ;
- les solutions peuvent proposer accès web, démonstration, téléchargement ou commande ;
- KoloService est mis en avant comme marketplace de services ;
- le parcours de commande/devis est découpé en trois étapes courtes ;
- chaque demande continue d’être traitée par `api/request.php` et reçoit une référence `EU-YYYYMMDD-XXXXXX`.

## Identité visuelle V3.1

La V3.1 reprend le langage visuel historique d’Elite-US / Dynamic Technology Systems : bleu nuit, halos technologiques, particules, animations d’entrée, effets lumineux, cartes animées, carrousel des projets et bandeau technologique. Les animations respectent `prefers-reduced-motion`.

## Nomenclature produit importante

**MarnComs est le nom canonique de l’application également connue sous les appellations SmarC-SMU et SmarC-SMW. Il s’agit d’une seule et même application, et non de trois produits distincts.**

MarnComs couvre notamment :

- communication digitale multicanale ;
- envoi de SMS ;
- envoi d’e-mails ;
- envoi de messages WhatsApp ;
- campagnes marketing ;
- ciblage d’audiences ;
- notifications ;
- suivi et analyse des actions de communication.

## Fichiers principaux

- `index.html` — portail public ;
- `assets/css/styles.css` — styles responsive ;
- `assets/css/visual-v31.css` — thème visuel et animations ;
- `assets/js/app.js` — catalogue, filtres, orientation, carrousel et tunnel de commande ;
- `assets/data/catalog.fr.json` — catalogue public des produits/services ;
- `assets/img/` — médias produits ;
- `api/request.php` — réception et journalisation des demandes ;
- `privacy.html` — confidentialité ;
- `robots.txt` / `sitemap.xml` — SEO technique.

## Catalogue public

Chaque produit peut définir son nom, sa catégorie, son statut, ses plateformes, ses mots-clés, ses alias, ses URLs, ses téléchargements et ses visuels. À terme, ce fichier statique pourra être remplacé par l’API du catalogue central sans changer la logique générale du portail.

## Déploiement

Déployer sur Apache/PHP. Vérifier que PHP peut écrire dans `storage/requests/` et configurer un transport e-mail de production. Les demandes clients ne doivent jamais être publiées dans Git.

## Validation

Le workflow `.github/workflows/validate-site.yml` contrôle JavaScript, PHP, JSON, références médias, SVG, CSS et protection du stockage.

## Sécurité

Le dossier `storage/` reste protégé par `.htaccess`. Les secrets, clés API et données clients ne doivent jamais être placés dans le dépôt public.

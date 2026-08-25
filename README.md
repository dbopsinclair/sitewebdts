# Elite-US Corporate Website v2

Refonte du site vitrine Elite-US (anciennement Dynamic Technology Systems).

## Objectifs
- présenter clairement les services et solutions ;
- supprimer les images cassées grâce à des monogrammes CSS tant que les logos officiels ne sont pas disponibles ;
- permettre à un prospect de commander, demander un devis, une démonstration ou exprimer un besoin ;
- enregistrer chaque demande avec une référence et tenter un envoi par e-mail ;
- améliorer SEO, responsive design, accessibilité et maintenabilité.

## Déploiement XAMPP/Apache
Copier le contenu du projet dans le dossier web. Vérifier que PHP peut écrire dans `storage/requests/` et que la fonction `mail()` est configurée sur le serveur de production.

## À remplacer plus tard
Les monogrammes produits (PS, ZM, KS, etc.) sont temporaires. Remplacez-les par les logos officiels quand ils sont disponibles.

## Sécurité
Le dossier `storage/` est protégé par `.htaccess` et son contenu dynamique est ignoré par Git. Ne jamais publier les demandes clients.

## Flux commercial
Le formulaire `index.html#commande` envoie les demandes vers `api/request.php`. Une référence unique `EU-YYYYMMDD-XXXXXX` est retournée au client. Aucune transaction financière n'est débitée à cette étape : la demande ouvre le processus de qualification/devis.

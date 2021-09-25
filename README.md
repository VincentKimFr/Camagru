# Camagru

Premier projet web de 42 à part ertière, il vise à créer un site viable, sécurisé et avec base de données.
Je l’ai implémenté sur un serveur local à l’aide de Xampp, codé en PHP, librairie standard, et MySQL coté serveur. Conformément au sujet,  le coté client est en HTML, CSS et Javascript (limité aux API natives des navigateurs.

Sont implémentés :
- Structuration MVC
- Mot de passe hashés, protection contre les injections de code dans des variables affichées, préparations des requètes MySQL, vérification de l’authentification lors de modifications de contenus…
- L’incription de comptes utilisateurs avec email, nom d’utilisateur et mot de passe (vérification de la sécurité des mots de passe)
- Confirmation du compte par un lien en e-mail (ici en l’absence de serveur mail les contenus de mails s’affichent volontairement sur le site)
- Possibilité de réinitialisation du mot de passe par e-mail
- Possibilité de se connecter à son compte pour accéder à ses options et à la page de montage ("webcam")
- La page d’option permet de modifier son mail, mot de passe, ou nom d’utilisateur
- Deconnexion possible depuis n’importe quelle page
- Réinitialisation du mot de passe par mail en cas d’oublis
- La page webcam permet de prendre une photo depuis sa webcam ou d’uploader une image, ainsi que de voir et supprimer ses images et photo

Non implémenté :
- Conteneurisation
- Site responsive
- Flux webcam ou image uploadé superposable à des images fournies et traitement d’image coté serveur pour enregistrer le résulat ensuite
- Gallerie publique paginée, au moins 5 élements par pages, possibilité de commenter avec un compte
- Notification 

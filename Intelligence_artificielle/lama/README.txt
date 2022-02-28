IMPORTANT : le dossier parent ‘lama’ doit être téléchargé ENTIER
Les chemins d'accès sont RELATIFS et fonctionnent uniquement grâce à la présence de toutes les données/les scripts dans ‘lama’.
Renommer ce répertoire ne cassera rien par contre.
IMPORTANT 2 : La machine doit avoir les packages python concernés installés (tensorflow, keras, pandas, sys (mais ça normalement il est de base dans toutes les installs de python))


>À ne pas toucher : 
trainModels.py : entraine les deux réseaux (un à reconnaitre les harcèlement, l'autre à reconnaitre le non-harcèlement). Pour n'en entraîner qu'un, changez la localisation de la sauvegarde du réseau et exécutez uniquement la première partie du code (suivre les commentaires).

>Ne fonctionnent que dans un IDE
predictIDESimple.py : utilise un seul réseau entraîné par trainModels.py pour déterminer si du texte fourni est du harcèlement (modèle "Simple")
predictIDEDual.py : utilise les 2 réseaux entraînés par trainModels.py pour déterminer si du texte fourni est du harcèlement

>script qui est compatible avec un lancement par un script PHP (il est laçanble depuis la console)
Predict.py renvoie False si c'est pas du harcèlement, True sinon, en utilisant les réseaux entraînés, selon le mode sélectionné
lancé par l'instruction :
>python PATH/lama/Predict.py phrase à évaluer, et si le premier mot est 'mode:dual' ou 'mode:simple' on utilisera un réseau ou les deux, avec un seul par défaut.


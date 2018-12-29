# SSAGR4

### Prérequis

Liens : 
* [WAMP](https://sourceforge.net/projects/wampserver/files/latest/download) - wampserver3.1.4_x64.exe
* [GIT](https://git-scm.com/download/win) - Download de GIT windows
>Si vous avez des soucis ne pas hésiter à me contacter via le Slack (avec le @ sinon je risque de ne pas voir les messages)

<!-- ```
Give examples
''' -->

### Mise en place du projet
Un fois que Wamp est installé il faut :
* Aller dans le dossier : C:\wamp64\www
* Clic droit et cliquer sur "git Bash here"

    > ![git_bash](/_img_tuto/git_bash.png)
* Copie du projet symfony vierge : https://github.com/RomChaba/SSAGR4.git

    > ![git_clone](/_img_tuto/git_clone.png)
* Résultat :
    
    > ![home_symfony](/_img_tuto/home_symfony.png)

### Pour l'instalation de phpstorm

[Lien Download](https://www.jetbrains.com/phpstorm/download/#section=windows)

Pendant le téléchargement:  
Créer un compte avec le mail de l'ENI : [Lien](https://account.jetbrains.com/login)
Dans le mail reçu cliquer sur le lien de confirmation  

Connecter vous sur votre compte de phpstorm  
Allez dans l'onglet "Licenses" puis télécharger la version offline de votre license.  
Une fois le fichier téléchargé copier son contenu, et lancé phpstorm.  
Lors de l'installation de phpstorm il faut cocher "Dowload and install JRE x86 by JetBrains"

Un fois installé choisir l'interface que vous préferez, ensuite pour l'activation choisisez "Activation code" puis copier coller la version offline dans la zone puis Ok


### Pour l'installation de SQL SERVER

Télécharger SQL Server développeur depuis le site de logiciel pour l'eni :
[Lien](https://e5.onthehub.com/WebStore/Security/SignIn.aspx?rurl=%2fWebStore%2fSecurity%2fSignIn.aspx%3frurl%3d%252fWebStore%252fProductsByMajorVersionList.aspx%253fcmi_cs%253d1%2526cmi_mnuMain%253d6cce831e-9ca9-e511-9413-b8ca3a5db7a1%2526ws%253d1652a816-050d-e811-80fe-000d3af41938%2526vsro%253d8%26ws%3d1652a816-050d-e811-80fe-000d3af41938%26vsro%3d8&ws=1652a816-050d-e811-80fe-000d3af41938&vsro=8)

En vous connectant avec vos identifiants de l'ENI. Puis faire une recherche pour "sql server" et télécharger la version "SQL Server 2017 Developer" en french :
> ![Img](/_img_tuto/sqlserv_download.png) 

Executer l'iso, choisir "Instalation" puis le premier "Nouvelle instalation ..."
> ![Img](/_img_tuto/sqlserv_install.png) 

Faire "Suivant, Suivant, Suivant, ..."

### Ajout des librairies de communication pour php et sql server

Il faut télécharger les "dll" qui sont dans le dossier _source [lien](_source\ext.rar)

Les mettres dans le dossier de php "C:\wamp64\bin\php\php7.2.10\ext"

Et les ajouter dans les fichiers de config de php et de apache "php.ini"
* C:\wamp64\bin\php\php7.2.10
* C:\wamp64\bin\apache\apache2.4.35\bin

Ajouter les lignes ci-dessous à la fin du groupe d'extension
```ini
extension=php_pdo_sqlsrv_72_ts_x64.dll
extension=php_sqlsrv_72_ts_x64.dll
```
Puis relancer Wampp.


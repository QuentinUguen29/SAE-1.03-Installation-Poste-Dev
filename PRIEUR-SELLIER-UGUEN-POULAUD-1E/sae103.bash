#!/bin/bash

# Générateur de Versions
client=$(cut -d"=" -f2 < config | head -1)
produit=$(cut -d"=" -f2 < config | head -2 | tail -1)
major=$(cut -d"=" -f2 < config | tail -1 | cut -d"." -f1)
minor=$(cut -d"=" -f2 < config | tail -1 | cut -d"." -f2)
build=$(cut -d"=" -f2 < config | tail -1 | cut -d"." -f3)
rendu=$(cut -d"=" -f2 < config | head -1 | tr " " "_" | tr A-Z a-z)

case $1 in
	--major)
    	let "major+=1"
    	let "minor=0"
    	let "build=0"
    ;;
    
  	--minor)
   		let "minor+=1"
    	let "build=0"
    ;;

  	--build)
    	let "build+=1"
    ;;
    
    *)
    	echo -e "Vous n'avez pas donné de Version ou vous en avez entré une mauvaise\nNous attendons --major, --minor ou --build"
		exit 1
    ;;
    
esac

echo "CLIENT=$client" > config
echo "PRODUIT=$produit" >> config
echo "VERSION=$major.$minor.$build" >> config
##

# Commande pour fichiers C

mkdir fichiersC
mv *.c fichiersC/.

##

# Commande docker

docker volume create sae103

#docker pull image clock
docker container run --rm -tid --name sae103-forever -v sae103:/work clock
docker container cp fichiersC/. sae103-forever:/work
docker container cp doc_utilisateur.md sae103-forever:/work
docker container cp DOC_USER.css sae103-forever:/work
docker container cp DOC_TECHNIQUE.css sae103-forever:/work
docker container cp config sae103-forever:/work
docker container cp gendoc-user.php sae103-forever:/work
docker container cp gendoc-tech.php sae103-forever:/work

#docker pull image sae103-php
docker container run --rm -v sae103:/work sae103-php sh -c "php gendoc-tech.php > doc_tech-$major.$minor.$build.html"
docker container run --rm -v sae103:/work sae103-php sh -c "php gendoc-user.php > doc_user-$major.$minor.$build.html"

#docker pull image sae103-html2pdf
docker container run --rm -v sae103:/work sae103-html2pdf "html2pdf doc_tech-$major.$minor.$build.html  doc_tech-$major.$minor.$build.pdf"
docker container run --rm -v sae103:/work sae103-html2pdf "html2pdf doc_user-$major.$minor.$build.html  doc_user-$major.$minor.$build.pdf"

docker container exec sae103-forever mkdir /work/ArchiveFinale
docker container exec sae103-forever mv /work/doc_tech-$major.$minor.$build.pdf /work/ArchiveFinale/
docker container exec sae103-forever mv /work/doc_tech-$major.$minor.$build.html /work/ArchiveFinale/
docker container exec sae103-forever mv /work/doc_user-$major.$minor.$build.pdf /work/ArchiveFinale/
docker container exec sae103-forever mv /work/doc_user-$major.$minor.$build.html /work/ArchiveFinale/
docker container exec sae103-forever mv /work/config /work/ArchiveFinale/
docker container exec sae103-forever mv /work/DOC_TECHNIQUE.css /work/ArchiveFinale/
docker container exec sae103-forever mv /work/DOC_USER.css /work/ArchiveFinale/
docker container exec sae103-forever mv /work/doc_utilisateur.md /work/ArchiveFinale/
docker container run --rm -v sae103:/work sae103-php sh -c "mv /work/*.c /work/ArchiveFinale"

docker container run --rm -v sae103:/work sae103-php sh -c "tar czvf /work/$rendu-$major.$minor.$build.tar.gz /work/ArchiveFinale"
docker cp sae103-forever:/work/$rendu-$major.$minor.$build.tar.gz .

docker kill sae103-forever
docker container prune -f
docker volume rm sae103

##

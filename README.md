# Gestion de la réservation d'une base
[![Build Status](https://travis-ci.org/AnaelMobilia/sgdf38-praleron.svg?branch=master)](https://travis-ci.org/AnaelMobilia/sgdf38-praleron)

Requiert un fichier Google Sheet avec 2 onglets : PLANNING et CONFIGURATION
PLANNING :
  - Colonne A : les jours (forme jj/mm/aaaa)
  - ligne 1 : les noms des lieux

CONFIGURATION :
  - ligne 1 : les noms des lieux
  - ligne 2 : lieu indisponible par défaut ? (jamais disponible)
  - ligne 3 : date début non dispo (période spécifique où le terrain n'est pas dispo)
  - ligne 4 : date fin non dispo
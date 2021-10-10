# Wetterstation für den Raspberry PI mit Funkverbindung

Die Wetterstation misst Temperatur, Feuchtigkeit, Regen und Wind. Die Daten werden auf einen Dashboard ausgegeben. Ich verwende dazu Funk Sensoren von Amazon. Somit kannst du alle 15 Minuten das Wetter abrufen. Weiterhin zeige ich, wie man noch das Dashboard mit einer Wetterapi verknüpfen kann. 

# Hardware
Du brauchst dazu: 

* <a href="https://amzn.to/3zHNZnH" target="_blank">Raspberry PI 3</a>
* <a href="https://all-inkl.com/PA3BB517416727D" target="_blank"> Eigene SQL Datenbank bei einem Provider</a>
* Temperature: <a href="https://amzn.to/3oPndbq">TFA Dostmann Thermo-Hygro-Sender, 30.3221.02</a>
* Rain: <a href ="https://amzn.to/3Dqihh4">TFA Dostmann 30.3222.02</a>
* Wind: <a href="https://amzn.to/30eydor">TFA Dostmann 30.3161 </a>
* Stick: <a href="https://amzn.to/3anco7Z"> RTL-SDR Stick </a>
* Antenne: <a href="https://amzn.to/3aExHlH"> Delock 88877 ISM SMA Omni Star  </a>
* Active USB HUB (Energy): <a href="https://amzn.to/3arlGj8"> CSL USB HUB </a>

# Disclaimer

Ich weis, dass man die Applikation sicher schöner programmieren kann und bspw. den String in Python direkt kürzen kann. Allerdings habe ich die Software programmiert bevor die Sensoren da waren. Da es ein privates Projekt ist und funktioniert, lasse ich es so. Aber falls mir jemand helfen möchte, kannst du gerne den Code noch sauber ziehen. Ich freue mich über jede Hilfe!

# Wetterstation für den Raspberry PI mit Funkverbindung

Die Wetterstation misst Temperatur, Feuchtigkeit, Regen und Wind. Die Daten werden auf einen Dashboard ausgegeben. Ich verwende dazu Funk Sensoren von Amazon. Somit kannst du alle 15 Minuten das Wetter abrufen. Weiterhin zeige ich, wie man noch das Dashboard mit einer Wetterapi verknüpfen kann. 

<img src="https://agile-unternehmen.de/stuff/Wetterstation-sql-final.png">
<img src="https://agile-unternehmen.de/stuff/sql-wetterstation1.png">

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

# Vorbereitung

* Den RTL-SDR Stick steckst du in den aktiven USB Hub und dann in den Raspberry (so kriegt der Stick genug Strom für den Dauerbetrieb)
* pip install mysql-connector-python
* pip install python3
* <b>Nun installieren wir den Stick </b>
* git clone git://git.osmocom.org/rtl-sdr.git
* cd rtl-sdr
* mkdir build
* cd build
* cmake -DDETACH_KERNEL_DRIVER=ON ../
* make
* sudo make install
* sudo ldconfig
* <b> Nun installieren wir eine Software zum Auslesen der Sensoren </b>
* git clone git://github.com/merbanan/rtl_433
* cd rtl_433
* mkdir build
* cd build
* cmake ../
* make
* sudo make install

# Sensoren bestimmen

# Datenbanken anlegen
* Lege dir eine Datenbank bei einem  <a href="https://all-inkl.com/PA3BB517416727D" target="_blank"> Provider wie all-inkl an.</a>
* Lege die folgenden Datenbanken wie im Bild beschrieben kann.
* Ich habe dir auch eine Anleitung mitgegeben was die genau anlegen sollst. Es sind 4 Tabellen, welche alle gleich sind nur der Name variert.
* Achte auf Groß und Kleinschreibung

<img src="https://agile-unternehmen.de/stuff/sql-wetterstation.png">

# Python Dateien aus dem Raspberry
* Line23: Put your SQL Data in
* Line31 and 28: Put your SQL Statement in
* Start the file SQL_RTL_433.service
* Put the Service file to the right place
* sudo mv SQL_RTL_433.service /etc/systemd/system
* sudo systemctl enable SQL_RTL_433.service
* sudo systemctl start SQL_RTL_433.service
* Check it : sudo systemctl status SQL_RTL_433.service

# Disclaimer

Ich weis, dass man die Applikation sicher schöner programmieren kann und bspw. den String in Python direkt kürzen kann. Allerdings habe ich die Software programmiert bevor die Sensoren da waren. Da es ein privates Projekt ist und funktioniert, lasse ich es so. Aber falls mir jemand helfen möchte, kannst du gerne den Code noch sauber ziehen. Ich freue mich über jede Hilfe!

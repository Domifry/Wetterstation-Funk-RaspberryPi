# Wetterstation für den Raspberry PI mit Funkverbindung

Die Wetterstation misst Temperatur, Feuchtigkeit, Regen und Wind. Die Daten werden auf einen Dashboard ausgegeben. Ich verwende dazu Funk Sensoren von Amazon. Somit kannst du alle 15 Minuten das Wetter abrufen. Weiterhin zeige ich, wie man noch das Dashboard mit einer Wetterapi verknüpfen kann. Ich berechne im Script anhand der Luftfeuchtigkeit und des Wind die gefühlte Temperatur. So kannst du aus den Messwerten auch etwas für dich mitnehmen. 

<img src="https://agile-unternehmen.de/stuff/wetterstation-raspberry-funk-1.png">
<img src="https://agile-unternehmen.de/stuff/sql-wetterstation1.png">

# Hardware
Du brauchst dazu: 

* <a href="https://amzn.to/3zHNZnH" target="_blank">Raspberry PI 3</a>
* <a href="https://all-inkl.com/PA3BB517416727D" target="_blank"> Eigene SQL Datenbank bei einem Provider</a>
* Temperature: <a href="https://amzn.to/3oPndbq">TFA Dostmann Thermo-Hygro-Sender, 30.3221.02</a> (das brauchst du 2 Mal - einer kommt in die Sonne und einer in den Schatten)
* Rain: <a href ="https://amzn.to/3Dqihh4">TFA Dostmann 30.3222.02</a>
* Wind: <a href="https://amzn.to/30eydor">TFA Dostmann 30.3161 </a>
* Stick: <a href="https://amzn.to/3vshPfx"> RTL-SDR Stick </a>
* Antenne: <a href="https://amzn.to/30ytm1D">Technikkram 433 MHz Antenne  </a>
* Active USB HUB (Energy): <a href="https://amzn.to/3arlGj8"> CSL USB HUB </a>

# Vorbereitung

Den RTL-SDR Stick steckst du in den aktiven USB Hub und dann in den Raspberry (so kriegt der Stick genug Strom für den Dauerbetrieb)

```
pip install mysql-connector-python
pip install python3
```

<b>Nun installieren wir den Stick </b>

```
git clone git://git.osmocom.org/rtl-sdr.git
cd rtl-sdr
mkdir build
cd build
cmake -DDETACH_KERNEL_DRIVER=ON ../
make
sudo make install
sudo ldconfig
```

<b> Nun installieren wir eine Software zum Auslesen der Sensoren </b>
```
git clone git://github.com/merbanan/rtl_433
cd rtl_433
mkdir build
cd build
cmake ../
make
sudo make install
```

<b> Kopieren wir die Files auf den Raspberry</b>
```
git clone https://github.com/Domifry/Wetterstation-Funk-RaspberryPi
cd Wetterstation-Funk-RaspberryPi
sudo mv SQL_RTL_433.service /etc/systemd/system
```

# Sensoren bestimmen
* gib zuerst ein sudo rtl_433 -R 73 -R 37
* Schaue die die Eingaben an und ob du deine Sensoren findest! Siehe Bild unten.
* Falls einige nicht kommen probiere andere Frequenzen: sudo rtl_433 -f 433.9M und rtl_433 -f 433.8M oder 433.95M oder nutze sudo rtl_433 -M level (du siehst die Frequenzen)
* Für das Setup ist die beste Frequenz: 433.95M
* Wenn du alle gefunden hast, brauchst du die ID'S
* sudo rtl_433 -F json -f 433.9M 
* Die Ausgabe ist nun ungefähr so:
* {"time" : "2021-10-09 21:08:27", "model" : "LaCrosse-TX141W", "id" : 86798, "channel" : 0, "battery_ok" : 1, "wind_avg_km_h" : 2.300, "wind_dir_deg" : 0, "test" : 0, "mic" : "CRC"}
* Das ist ein JSON String. Den kannst du in eine Datenbank packen. Schreibe dir dazu die ID auf wie hier: 86798
* Mache das für alle Sensoren, welche du hast

<img src="https://agile-unternehmen.de/stuff/sensordaten.png">

# Datenbanken anlegen
* Lege dir eine Datenbank bei einem  <a href="https://all-inkl.com/PA3BB517416727D" target="_blank"> Provider wie all-inkl an.</a>
* Lege die folgenden Datenbanken wie im Bild beschrieben kann.
* Ich habe dir auch eine Anleitung mitgegeben was die genau anlegen sollst. Es sind 4 Tabellen, welche alle gleich sind nur der Name variert.
* Achte auf Groß und Kleinschreibung

<img src="https://agile-unternehmen.de/stuff/sql-wetterstation.png">

# Python Dateien aus dem Raspberry
* Line23: Trage die Daten deiner SQL Datenbank ein
* Mache alle Sensoren, welche du nicht nutzen willst raus 
* Gehe in den Order 
* cd Wetterstation-Funk-RaspberryPi
* sudo nano rtl-sql.py
* Trage bei jedem IF Statement (32,36,40 und 44) die ID's der Sensoren ein
* Trage deine SQL Daten ein in Zeile 29
* Trage noch deinen Datenbanknamen in Zeile 33,37,41 und 45 ein
* Ändere die Frequenz in Zeile 12 wenn nötig
* Nun starten wir das Script noch automatisch und lassen es alle 15 Minuten Daten abholen
* sudo mv SQL_RTL_433.service /etc/systemd/system
* sudo systemctl enable SQL_RTL_433.service
* sudo systemctl start SQL_RTL_433.service
* Check it : sudo systemctl status SQL_RTL_433.service

# Bilder
Suche dir vier Bilder - meine habe ich von einer Bilderdatenbank gekauft für jeweils 1 Dollar.
* Temperaturicon: https://www.creativefabrica.com/de/product/temperature-icon-4/
* Free Wind Icon: https://www.iconfinder.com/icons/316050/wind_icon
* Free Feuchtigkeit Icon: https://icon-icons.com/de/symbol/Luftfeuchtigkeit-Wetter/52507
* Free Rain Icon: https://icon-icons.com/de/symbol/cloud-Natur-Regen-Wetter/99845
* Lege die Bilder ein einen order img mit Namen: wind.png, sonne.png, schatten.png, luftfeuchtigkeit.png, regen.png

# Index.php
* Lege die index.php in einen Order und baue einen Unterorder img mit den Bildern auf deinem Webspace
* Trage deine SQL Daten in die Datei ein (ganz oben)
* rufe die Seite auf

# index.php und Wetterbericht
* Wenn du einen Wetterbericht noch haben willst, dann hole dir einen API Key auf https://openweathermap.org
* Kommentiere die Zeilen 11 - 95 und 496 - 509 ein

# Kühlung
Aktuell wird der Stick nach einiger Zeit sehr warm und bricht ab. Ich habe einen Lüfter auf einer Raspberry Hülle geschraubt und kühle es aktuell mit 3,3V. Aktuell läuft es seit ein paar Tagen durch. Es funktioniert denke ich damit sehr gut.

# Disclaimer

Ich weis, dass man die Applikation sicher schöner programmieren kann und bspw. den String in Python direkt kürzen kann. Allerdings habe ich die Software programmiert bevor die Sensoren da waren. Da es ein privates Projekt ist und funktioniert, lasse ich es so. Aber falls mir jemand helfen möchte, kannst du gerne den Code noch sauber ziehen. Ich freue mich über jede Hilfe!

#!/usr/bin/env python3


import mysql.connector
import time
import subprocess
import os
import sys
import http.client, urllib

proc = subprocess.Popen(['rtl_433','-R', '73', '-R','37','-F', 'json'], stdout=subprocess.PIPE)
sensor1 = False
sensor2 = False
sensor3 = False
connected = False
counter = 0

while True:
  line = proc.stdout.readline()
  #print(line.rstrip())
  json1 = line.rstrip()
  json = str(json1)
  json = json.lstrip("'")
  json = json.lstrip("b")
  json = json.lstrip("'")
  json = json.rstrip("'")
  #print("geht:"+json)
  counter+=1
  #if not line:
  #  break
  if connected == False:
   connection = mysql.connector.connect(host="85.13.145.112", user="d03794ba", passwd="uP6TVnAT4JH2FXe3", db="d03794ba")
   cursor = connection.cursor()
   connected = True
  if "226" in json and sensor1 == False:
   statement = "INSERT INTO `d03794ba`.`Schatten` (`ID`, `Schatten`, `Zeit`) VALUES (NULL,' "+json+"', current_timestamp())"
   cursor.execute(statement)
   sensor1 = True
  if "240" in json and sensor2 == False:
   statement = "INSERT INTO `d03794ba`.`Sonne` (`ID`, `Sonne`, `Zeit`) VALUES (NULL, '"+json+"', current_timestamp())"
   cursor.execute(statement)
   sensor2 = True
  if "86798" in json and sensor3 == False and "wind_avg_km_h" in json:
   statement = "INSERT INTO `d03794ba`.`Wind` (`ID`, `Wind`, `Zeit`) VALUES (NULL,'"+json+"', current_timestamp())"
   cursor.execute(statement)
   sensor3 = True
  if "Inovalley-kw9015b" in json and sensor4 == False:
   statement = "INSERT INTO `d03794ba`.`Regen` (`ID`, `Regen`, `Zeit`) VALUES (NULL,'"+json+"', current_timestamp())"
   cursor.execute(statement)
   sensor4 = True
  if counter == 100:
   proc = subprocess.Popen(['rtl_433','-R', '73', '-F', 'json'], stdout=subprocess.PIPE)
   nachricht = "100 erfolglose Versuche"
   if sensor1 == False:
    nachricht = nachricht+"<br>Sensor Schatten"
   if sensor2 == False:
    nachricht = nachricht+"<br>Sensor Sonne"
   if sensor3 == False:
    nachricht = nachricht+"<br>Sensor Wind"
   if sensor4 == False:
    nachricht = nachricht+"<br>Sensor Regen"
   conn = http.client.HTTPSConnection("api.pushover.net:443")
   conn.request("POST", "/1/messages.json",
   urllib.parse.urlencode({
   "token": "aengikvws6xiojofjw3qvwqj86cxca",
   "user": "ur3teosv7vc23fyskfa4g643h8m4v1",
   "message": nachricht,
   }), { "Content-type": "application/x-www-form-urlencoded" })
   conn.getresponse()
  if counter == 150:
   conn = http.client.HTTPSConnection("api.pushover.net:443")
   conn.request("POST", "/1/messages.json",
   urllib.parse.urlencode({
   "token": "aengikvws6xiojofjw3qvwqj86cxca",
   "user": "ur3teosv7vc23fyskfa4g643h8m4v1",
   "message": "Wetterstation wird beendet!",
   }), { "Content-type": "application/x-www-form-urlencoded" })
   break
  if sensor1 == True and sensor2 == True and sensor3 == True:
   sensor1 = False
   sensor2 = False
   sensor3 = False
   sensor4 = False
   connected = False
   connection.commit()
   cursor.close()
   counter = 0
   #print("erfolg")
   #time.sleep(10)
   time.sleep(900)
   #print(line.rstrip())



#!/usr/bin/env python3
# Github Domifry
# Support Github mrkwenzel

import mysql.connector
import time
import subprocess
import os
import sys
import http.client, urllib

proc = subprocess.Popen(['rtl_433','-R', '73', '-R', '37','-F' , 'json', '-f', '433.95M'], stdout=subprocess.PIPE)
sensor1 = False
sensor2 = False
sensor3 = False
sensor4 = False
connected = False
counter = 0

while True:
  line = proc.stdout.readline())
  json1 = line.rstrip()
  json = str(json1)
  json = json.lstrip("'")
  json = json.lstrip("b")
  json = json.lstrip("'")
  json = json.rstrip("'")
  counter+=1
  if connected == False:
   connection = mysql.connector.connect(host="ID", user="user", passwd="pass", db="user")
   cursor = connection.cursor()
   connected = True
  if "ID" in json and sensor1 == False:
   statement = "INSERT INTO `NAME`.`Schatten` (`ID`, `Schatten`, `Zeit`) VALUES (NULL,' "+json+"', current_timestamp())"
   cursor.execute(statement)
   sensor1 = True
  if "ID" in json and sensor2 == False:
   statement = "INSERT INTO `NAME`.`Sonne` (`ID`, `Sonne`, `Zeit`) VALUES (NULL, '"+json+"', current_timestamp())"
   cursor.execute(statement)
   sensor2 = True
  if "ID" in json and sensor3 == False and "wind_avg_km_h" in json:
   statement = "INSERT INTO `NAME`.`Wind` (`ID`, `Wind`, `Zeit`) VALUES (NULL,'"+json+"', current_timestamp())"
   cursor.execute(statement)
   sensor3 = True
  if "ID" in json and sensor4 == False and "rain" in json:
   statement = "INSERT INTO `NAME`.`Regen` (`ID`, `Wind`, `Zeit`) VALUES (NULL,'"+json+"', current_timestamp())"
   cursor.execute(statement)
   sensor3 = True
  if counter == 100:
   # sollte 100 mal nichts ankommen, startet er das script neu
   proc = subprocess.Popen(['rtl_433','-R', '73', '-R', '37','-F', 'json', '-f'], stdout=subprocess.PIPE)
  if counter == 150:
   #script ist kaputt und bricht ab
   break
  if sensor1 == True and sensor2 == True and sensor3 == True and sensor4 == true:
   sensor1 = False
   sensor2 = False
   sensor3 = False
   sensor4 = False
   connected = False
   connection.commit()
   cursor.close()
   counter = 0
   time.sleep(900)
